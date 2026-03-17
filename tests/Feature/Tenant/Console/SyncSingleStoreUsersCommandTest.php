<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;

it('adds the only store to every user in single-store tenants', function (): void {
    $store = Store::query()->sole();
    $unassignedUser = User::query()->create([
        'name' => 'Unassigned User',
        'email' => 'unassigned@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $assignedUser = User::query()->create([
        'name' => 'Assigned User',
        'email' => 'assigned@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);

    $assignedUser->stores()->attach($store->id);

    tenancy()->end();

    $this->artisan('stores:sync-single-store-users', ['--tenants' => [$this->tenant->id]])
        ->expectsOutput("Tenant {$this->tenant->id}: synced 3 user(s) to store {$store->id}.")
        ->assertSuccessful();

    $this->tenant->run(function () use ($assignedUser, $store, $unassignedUser): void {
        expect($this->consultant->fresh()->stores()->pluck('stores.id')->all())->toBe([$store->id]);
        expect($this->manager->fresh()->stores()->pluck('stores.id')->all())->toBe([$store->id]);
        expect($unassignedUser->fresh()->stores()->pluck('stores.id')->all())->toBe([$store->id]);
        expect($assignedUser->fresh()->stores()->pluck('stores.id')->all())->toBe([$store->id]);
    });
});

it('skips tenants that do not have exactly one store', function (): void {
    Store::query()->create([
        'name' => 'Second Store',
        'slug' => 'second-store',
    ]);

    tenancy()->end();

    $this->artisan('stores:sync-single-store-users', ['--tenants' => [$this->tenant->id]])
        ->expectsOutput("Skipping tenant {$this->tenant->id}: expected 1 store, found 2.")
        ->assertSuccessful();

    $this->tenant->run(function (): void {
        expect($this->consultant->fresh()->stores()->exists())->toBeFalse();
        expect($this->manager->fresh()->stores()->exists())->toBeFalse();
    });
});
