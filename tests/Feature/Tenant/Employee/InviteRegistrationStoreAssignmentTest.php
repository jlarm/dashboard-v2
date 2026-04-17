<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Str;

describe('invite registration store assignment', function (): void {
    it('falls back to the only tenant store when invite stores are empty', function (): void {
        $store = Store::query()->firstOrFail();
        $department = Department::query()->create([
            'name' => 'Invite Department Fallback '.uniqid(),
            'slug' => 'invite-department-fallback-'.uniqid(),
        ]);

        $invite = Invite::query()->create([
            'name' => 'Fallback Store Invite User',
            'email' => 'fallback-store-invite-user@test.com',
            'stores' => [],
            'department_id' => $department->id,
            'user_id' => $this->consultant->id,
            'roles' => ['Employee'],
            'invitation_token' => Str::random(32),
            'courses' => [],
        ]);

        $this->post(route('dealer.employees.store'), [
            'id' => $invite->id,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(AppServiceProvider::HOME);

        $user = User::query()->where('email', 'fallback-store-invite-user@test.com')->firstOrFail();

        expect($user->current_store_id)->toBe($store->id);
        expect($user->stores()->pluck('stores.id')->all())->toBe([$store->id]);
    });

    it('assigns one invited store and sets current_store_id', function (): void {
        $store = Store::query()->firstOrFail();
        $department = Department::query()->create([
            'name' => 'Invite Department '.uniqid(),
            'slug' => 'invite-department-'.uniqid(),
        ]);

        $invite = Invite::query()->create([
            'name' => 'Single Store Invite User',
            'email' => 'single-store-invite-user@test.com',
            'stores' => [$store->id],
            'department_id' => $department->id,
            'user_id' => $this->consultant->id,
            'roles' => ['Employee'],
            'invitation_token' => Str::random(32),
            'courses' => [],
        ]);

        $this->post(route('dealer.employees.store'), [
            'id' => $invite->id,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(AppServiceProvider::HOME);

        $user = User::query()->where('email', 'single-store-invite-user@test.com')->firstOrFail();

        expect($user->current_store_id)->toBe($store->id);
        expect($user->stores()->pluck('stores.id')->all())->toBe([$store->id]);
    });

    it('assigns multiple invited stores and leaves current_store_id null', function (): void {
        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Invite Store B '.uniqid(),
            'address' => '22 Main St',
            'city' => 'Austin',
            'state' => 'TX',
            'postal_code' => '73301',
            'phone' => '512-555-0102',
            'website' => 'https://invite-store-b.test',
        ]);
        $department = Department::query()->create([
            'name' => 'Invite Department B '.uniqid(),
            'slug' => 'invite-department-b-'.uniqid(),
        ]);

        $invite = Invite::query()->create([
            'name' => 'Multi Store Invite User',
            'email' => 'multi-store-invite-user@test.com',
            'stores' => [$storeA->id, $storeB->id],
            'department_id' => $department->id,
            'user_id' => $this->consultant->id,
            'roles' => ['Employee'],
            'invitation_token' => Str::random(32),
            'courses' => [],
        ]);

        $this->post(route('dealer.employees.store'), [
            'id' => $invite->id,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(AppServiceProvider::HOME);

        $user = User::query()->where('email', 'multi-store-invite-user@test.com')->firstOrFail();
        $assignedStoreIds = $user->stores()->orderBy('stores.id')->pluck('stores.id')->all();

        expect($user->current_store_id)->toBeNull();
        expect($assignedStoreIds)->toBe([$storeA->id, $storeB->id]);
    });
});
