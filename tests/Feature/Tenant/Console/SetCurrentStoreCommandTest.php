<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;

it('updates every user current_store_id to 1 when the tenant has no locations enabled', function (): void {
    $userA = User::query()->create([
        'name' => 'Alpha',
        'email' => 'alpha@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $userB = User::query()->create([
        'name' => 'Bravo',
        'email' => 'bravo@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);

    tenancy()->end();
    $this->tenant->update(['locations' => false]);

    $this->artisan('set:current-store', ['--tenants' => [$this->tenant->id]])
        ->assertSuccessful();

    $this->tenant->run(function () use ($userA, $userB): void {
        expect($userA->fresh()->current_store_id)->toBe(1);
        expect($userB->fresh()->current_store_id)->toBe(1);
        expect($this->consultant->fresh()->current_store_id)->toBe(1);
        expect($this->manager->fresh()->current_store_id)->toBe(1);
    });
});

it('assigns each non-super/non-Consultant user their first attached store when locations is enabled', function (): void {
    $firstStore = Store::query()->firstOrFail();
    $secondStore = Store::query()->create(['name' => 'Second', 'slug' => 'second-'.uniqid()]);

    $employee = User::query()->create([
        'name' => 'Employee',
        'email' => 'employee@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $employee->assignRole('Employee');
    $employee->stores()->attach([$secondStore->id, $firstStore->id]);

    tenancy()->end();
    $this->tenant->update(['locations' => true]);

    $this->artisan('set:current-store', ['--tenants' => [$this->tenant->id]])
        ->assertSuccessful();

    $this->tenant->run(function () use ($employee, $firstStore, $secondStore): void {
        $assignedId = $employee->fresh()->current_store_id;

        // Command picks Eloquent's $user->stores()->first(); accept either attached store
        // rather than depend on the undefined ordering of an unordered BelongsToMany.
        expect($assignedId)->toBeIn([$firstStore->id, $secondStore->id]);
    });
});

it('leaves super-admin and Consultant users untouched when locations is enabled', function (): void {
    Store::query()->create(['name' => 'Extra', 'slug' => 'extra-'.uniqid()]);

    $superAdmin = User::query()->create([
        'name' => 'Super',
        'email' => 'super@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $superAdmin->assignRole('super-admin');

    tenancy()->end();
    $this->tenant->update(['locations' => true]);

    $this->artisan('set:current-store', ['--tenants' => [$this->tenant->id]])
        ->assertSuccessful();

    $this->tenant->run(function () use ($superAdmin): void {
        expect($superAdmin->fresh()->current_store_id)->toBeNull();
        expect($this->consultant->fresh()->current_store_id)->toBeNull();
    });
});

it('skips users with no attached stores when locations is enabled', function (): void {
    Store::query()->create(['name' => 'Other', 'slug' => 'other-'.uniqid()]);

    $orphan = User::query()->create([
        'name' => 'Orphan',
        'email' => 'orphan@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $orphan->assignRole('Employee');

    tenancy()->end();
    $this->tenant->update(['locations' => true]);

    $this->artisan('set:current-store', ['--tenants' => [$this->tenant->id]])
        ->expectsOutputToContain('does not belong to any stores')
        ->assertSuccessful();

    $this->tenant->run(function () use ($orphan): void {
        expect($orphan->fresh()->current_store_id)->toBeNull();
    });
});
