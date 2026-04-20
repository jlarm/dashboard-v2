<?php

declare(strict_types=1);

use App\Models\Central\UserInvite;
use App\Models\User;
use App\Notifications\Central\UserInviteNotification;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
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
});

describe('index', function (): void {
    it('allows super-admin to view open invites', function (): void {
        $openInvite = UserInvite::factory()->create(['email' => 'open@example.com']);
        UserInvite::factory()->accepted()->create(['email' => 'accepted@example.com']);
        UserInvite::factory()->revoked()->create(['email' => 'revoked@example.com']);
        UserInvite::factory()->expired()->create(['email' => 'expired@example.com']);

        asSuperAdmin()
            ->get(route('employees.invites'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/user/Invites')
                ->has('openInvites.data', 1)
                ->where('openInvites.data.0.email', $openInvite->email)
            );
    });

    it('denies consultants', function (): void {
        asConsultant()
            ->get(route('employees.invites'))
            ->assertForbidden();
    });

    it('redirects guests to login', function (): void {
        $this->get(route('employees.invites'))
            ->assertRedirect(route('login'));
    });
});

describe('store', function (): void {
    it('creates an invite and dispatches a queued mail notification', function (): void {
        Notification::fake();

        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $this->actingAs($admin)
            ->post(route('employees.invites.store'), [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
            ])
            ->assertRedirect();

        $invite = UserInvite::query()
            ->where('email', 'jane@example.com')
            ->firstOrFail();

        expect($invite->name)->toBe('Jane Doe')
            ->and($invite->role)->toBe(UserInvite::CONSULTANT_ROLE)
            ->and($invite->invited_by)->toBe($admin->id)
            ->and($invite->expires_at)->not->toBeNull()
            ->and($invite->expires_at->isFuture())->toBeTrue();

        Notification::assertSentOnDemand(
            UserInviteNotification::class,
            fn ($notification, $channels, $notifiable) => in_array('mail', $channels, true)
                && $notifiable->routes['mail'] === 'jane@example.com',
        );
    });

    it('validates required fields', function (): void {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $this->actingAs($admin)
            ->from(route('employees.invites'))
            ->post(route('employees.invites.store'), [])
            ->assertRedirect(route('employees.invites'))
            ->assertSessionHasErrors(['name', 'email']);

        expect(UserInvite::query()->count())->toBe(0);
    });

    it('rejects an email that already belongs to a user', function (): void {
        User::factory()->create(['email' => 'taken@example.com']);

        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $this->actingAs($admin)
            ->from(route('employees.invites'))
            ->post(route('employees.invites.store'), [
                'name' => 'Someone',
                'email' => 'taken@example.com',
            ])
            ->assertRedirect(route('employees.invites'))
            ->assertSessionHasErrors('email');

        expect(UserInvite::query()->count())->toBe(0);
    });

    it('rejects a duplicate active invite for the same email', function (): void {
        UserInvite::factory()->create(['email' => 'pending@example.com']);

        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $this->actingAs($admin)
            ->from(route('employees.invites'))
            ->post(route('employees.invites.store'), [
                'name' => 'Another',
                'email' => 'pending@example.com',
            ])
            ->assertRedirect(route('employees.invites'))
            ->assertSessionHasErrors('email');

        expect(UserInvite::query()->count())->toBe(1);
    });

    it('allows re-inviting an email whose previous invite is inactive', function (): void {
        Notification::fake();

        UserInvite::factory()->accepted()->create(['email' => 'recycled@example.com']);
        UserInvite::factory()->revoked()->create(['email' => 'recycled@example.com']);
        UserInvite::factory()->expired()->create(['email' => 'recycled@example.com']);

        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $this->actingAs($admin)
            ->post(route('employees.invites.store'), [
                'name' => 'Recycle',
                'email' => 'recycled@example.com',
            ])
            ->assertRedirect();

        expect(UserInvite::query()->where('email', 'recycled@example.com')->count())->toBe(4);
    });

    it('denies consultants', function (): void {
        asConsultant()
            ->post(route('employees.invites.store'), [
                'name' => 'Jane',
                'email' => 'jane@example.com',
            ])
            ->assertForbidden();

        expect(UserInvite::query()->count())->toBe(0);
    });
});

describe('destroy', function (): void {
    it('deletes an invite as super-admin', function (): void {
        $invite = UserInvite::factory()->create();

        asSuperAdmin()
            ->delete(route('employees.invites.destroy', ['invite' => $invite]))
            ->assertRedirect();

        expect(UserInvite::query()->find($invite->id))->toBeNull();
    });

    it('denies consultants', function (): void {
        $invite = UserInvite::factory()->create();

        asConsultant()
            ->delete(route('employees.invites.destroy', ['invite' => $invite]))
            ->assertForbidden();

        $invite->refresh();
        expect($invite->exists)->toBeTrue();
    });

    it('returns 404 for unknown invites', function (): void {
        asSuperAdmin()
            ->delete(route('employees.invites.destroy', ['invite' => 99999]))
            ->assertNotFound();
    });
});
