<?php

declare(strict_types=1);

use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

describe('invited employee registration page', function (): void {
    beforeEach(function (): void {
        $this->department = Department::query()->create([
            'name' => 'Registration Dept '.uniqid(),
            'slug' => 'registration-dept-'.uniqid(),
        ]);

        $this->invite = Invite::query()->create([
            'name' => 'Newly Invited',
            'email' => 'newly-invited@test.com',
            'stores' => [Store::query()->value('id')],
            'department_id' => $this->department->id,
            'user_id' => $this->consultant->id,
            'roles' => ['Employee'],
            'invitation_token' => Str::random(32),
            'courses' => [],
        ]);
    });

    it('renders the Inertia registration page with invite details', function (): void {
        $storeName = (string) Store::query()->value('name');

        $this->get(route('dealer.employees.create', $this->invite))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/user/Register')
                ->where('invite.id', $this->invite->id)
                ->where('invite.name', 'Newly Invited')
                ->where('invite.email', 'newly-invited@test.com')
                ->where('invite.stores.0', $storeName),
            );
    });

    it('rejects a weak password via Password::defaults', function (): void {
        $this->post(route('dealer.employees.store'), [
            'id' => $this->invite->id,
            'password' => 'short',
            'password_confirmation' => 'short',
        ])->assertSessionHasErrors('password');

        expect(User::query()->where('email', 'newly-invited@test.com')->exists())->toBeFalse();
        expect(Invite::query()->find($this->invite->id))->not->toBeNull();
    });

    it('creates the user, deletes the invite, and logs them in on valid registration', function (): void {
        $this->post(route('dealer.employees.store'), [
            'id' => $this->invite->id,
            'password' => 'super-strong-pass',
            'password_confirmation' => 'super-strong-pass',
        ])->assertRedirect(AppServiceProvider::HOME);

        $user = User::query()->where('email', 'newly-invited@test.com')->firstOrFail();

        expect($user->email_verified_at)->not->toBeNull();
        expect(Invite::query()->find($this->invite->id))->toBeNull();
        expect(Auth::check())->toBeTrue();
        expect(Auth::id())->toBe($user->id);
    });
});
