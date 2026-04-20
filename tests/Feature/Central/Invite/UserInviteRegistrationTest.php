<?php

declare(strict_types=1);

use App\Models\Central\UserInvite;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('user_invites')->truncate();
    DB::table('model_has_roles')->truncate();
    DB::table('model_has_permissions')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    // The app-level Password::defaults() includes uncompromised() which would
    // hit the HIBP API during tests; scope it down to just length here.
    Password::defaults(fn () => Password::min(8));
});

function signedCreateUrl(UserInvite $invite): string
{
    return URL::temporarySignedRoute(
        'employees.create',
        $invite->expires_at,
        ['centralUserInvite' => $invite->id],
    );
}

function signedStoreUrl(UserInvite $invite): string
{
    return URL::temporarySignedRoute(
        'employees.store',
        $invite->expires_at,
        ['centralUserInvite' => $invite->id],
    );
}

describe('create', function (): void {
    it('renders the registration view for a valid signed URL', function (): void {
        $invite = UserInvite::factory()->create();

        $this->get(signedCreateUrl($invite))
            ->assertOk()
            ->assertViewIs('central.employee.register')
            ->assertViewHas('invite', fn (UserInvite $passed): bool => $passed->is($invite));
    });

    it('rejects unsigned URLs', function (): void {
        $invite = UserInvite::factory()->create();

        $this->get(route('employees.create', ['centralUserInvite' => $invite->id]))
            ->assertForbidden();
    });

    it('returns 410 Gone when the invite is already accepted', function (): void {
        $invite = UserInvite::factory()->accepted()->create();

        $this->get(signedCreateUrl($invite))
            ->assertStatus(410);
    });

    it('returns 410 Gone when the invite is revoked', function (): void {
        $invite = UserInvite::factory()->revoked()->create();

        $this->get(signedCreateUrl($invite))
            ->assertStatus(410);
    });

    it('rejects signed URLs whose expiry has passed', function (): void {
        $invite = UserInvite::factory()->create(['expires_at' => now()->addMinute()]);

        $url = signedCreateUrl($invite);

        $this->travel(2)->minutes();

        $this->get($url)->assertForbidden();
    });

    it('redirects authenticated users away (guest middleware)', function (): void {
        $invite = UserInvite::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(signedCreateUrl($invite))
            ->assertRedirect(AppServiceProvider::HOME);
    });
});

describe('store', function (): void {
    it('completes registration, logs the user in, and marks the invite accepted', function (): void {
        Event::fake([Registered::class]);

        $admin = User::factory()->create();
        $invite = UserInvite::factory()->create([
            'name' => 'Grace Hopper',
            'email' => 'grace@example.com',
            'role' => UserInvite::CONSULTANT_ROLE,
            'invited_by' => $admin->id,
        ]);

        $this->post(signedStoreUrl($invite), [
            'phone' => '555-123-4567',
            'password' => 'super-strong-pass',
            'password_confirmation' => 'super-strong-pass',
        ])->assertRedirect(AppServiceProvider::HOME);

        $user = User::query()->where('email', 'grace@example.com')->firstOrFail();

        expect($user->name)->toBe('Grace Hopper')
            ->and($user->phone)->toBe('555-123-4567')
            ->and($user->email_verified_at)->not->toBeNull()
            ->and(Hash::check('super-strong-pass', $user->password))->toBeTrue()
            ->and($user->hasRole(UserInvite::CONSULTANT_ROLE))->toBeTrue();

        $this->assertAuthenticatedAs($user);

        $invite->refresh();
        expect($invite->accepted_at)->not->toBeNull();

        Event::assertDispatched(
            Registered::class,
            fn (Registered $event): bool => $event->user->is($user),
        );
    });

    it('assigns the role stored on the invite rather than a hardcoded role', function (): void {
        $invite = UserInvite::factory()->create([
            'email' => 'roleinfo@example.com',
            'role' => 'Consultant',
        ]);

        $this->post(signedStoreUrl($invite), [
            'phone' => '555-000-1111',
            'password' => 'another-strong-pass',
            'password_confirmation' => 'another-strong-pass',
        ])->assertRedirect(AppServiceProvider::HOME);

        $user = User::query()->where('email', 'roleinfo@example.com')->firstOrFail();

        expect($user->hasRole('Consultant'))->toBeTrue()
            ->and($user->hasRole('super-admin'))->toBeFalse();
    });

    it('returns 410 Gone when the invite has been accepted', function (): void {
        $invite = UserInvite::factory()->accepted()->create();

        $this->post(signedStoreUrl($invite), [
            'phone' => '555-111-2222',
            'password' => 'valid-password',
            'password_confirmation' => 'valid-password',
        ])->assertStatus(410);

        expect(User::query()->where('email', $invite->email)->exists())->toBeFalse();
    });

    it('returns 410 Gone when the invite has been revoked', function (): void {
        $invite = UserInvite::factory()->revoked()->create();

        $this->post(signedStoreUrl($invite), [
            'phone' => '555-111-3333',
            'password' => 'valid-password',
            'password_confirmation' => 'valid-password',
        ])->assertStatus(410);

        expect(User::query()->where('email', $invite->email)->exists())->toBeFalse();
    });

    it('fails validation when a user with the invited email already exists', function (): void {
        $invite = UserInvite::factory()->create(['email' => 'existing@example.com']);
        User::factory()->create(['email' => 'existing@example.com']);

        $this->post(signedStoreUrl($invite), [
            'phone' => '555-222-3333',
            'password' => 'valid-password',
            'password_confirmation' => 'valid-password',
        ])->assertSessionHasErrors('email');

        $invite->refresh();
        expect($invite->accepted_at)->toBeNull();
    });

    it('requires a phone, password and password confirmation', function (): void {
        $invite = UserInvite::factory()->create();

        $this->post(signedStoreUrl($invite), [])
            ->assertSessionHasErrors(['phone', 'password']);

        expect(User::query()->where('email', $invite->email)->exists())->toBeFalse();

        $invite->refresh();
        expect($invite->accepted_at)->toBeNull();
    });

    it('requires the password confirmation to match', function (): void {
        $invite = UserInvite::factory()->create();

        $this->post(signedStoreUrl($invite), [
            'phone' => '555-999-0000',
            'password' => 'valid-password',
            'password_confirmation' => 'mismatch-password',
        ])->assertSessionHasErrors('password');

        expect(User::query()->where('email', $invite->email)->exists())->toBeFalse();
    });

    it('enforces the minimum password length', function (): void {
        $invite = UserInvite::factory()->create();

        $this->post(signedStoreUrl($invite), [
            'phone' => '555-999-0001',
            'password' => 'short',
            'password_confirmation' => 'short',
        ])->assertSessionHasErrors('password');
    });

    it('rejects unsigned submissions', function (): void {
        $invite = UserInvite::factory()->create();

        $this->post(route('employees.store', ['centralUserInvite' => $invite->id]), [
            'phone' => '555-999-0002',
            'password' => 'valid-password',
            'password_confirmation' => 'valid-password',
        ])->assertForbidden();

        expect(User::query()->where('email', $invite->email)->exists())->toBeFalse();
    });
});
