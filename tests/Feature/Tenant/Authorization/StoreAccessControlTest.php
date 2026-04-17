<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->tenant->locations = true;
    $this->tenant->save();

    $this->assignedStore = Store::query()->first();

    $this->unassignedStore = Store::query()->create([
        'name' => 'Unassigned Store',
        'slug' => 'unassigned-store',
        'address' => '999 Other St',
        'city' => 'Elsewhere',
        'state' => 'CA',
        'postal_code' => '90210',
    ]);

    $this->storeManager = User::query()->create([
        'name' => 'Store Manager',
        'email' => 'store-manager@test.com',
        'password' => bcrypt('password'),
    ]);
    $this->storeManager->assignRole('Manager');
    $this->storeManager->stores()->attach($this->assignedStore->id);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('Store Access Control', function (): void {
    it('allows managers to access single-store pages when they have a selected assigned store', function (): void {
        $this->storeManager->update(['current_store_id' => $this->assignedStore->id]);

        $this->actingAs($this->storeManager)
            ->get(route('dealer.audit.osha.index'))
            ->assertOk();
    });

    it('allows managers to access single-store pages when overview is selected and only one store is scoped', function (): void {
        $this->storeManager->update(['current_store_id' => null]);

        $this->actingAs($this->storeManager)
            ->get(route('dealer.audit.osha.index'))
            ->assertOk();
    });

    it('clears invalid selected stores for non-consultants and keeps access when one store remains in scope', function (): void {
        $this->storeManager->update(['current_store_id' => $this->unassignedStore->id]);

        $this->actingAs($this->storeManager)
            ->get(route('dealer.audit.osha.index'))
            ->assertOk();

        expect($this->storeManager->fresh()->current_store_id)->toBeNull();
    });

    it('allows consultants to use any selected store', function (): void {
        $this->consultant->update(['current_store_id' => $this->unassignedStore->id]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.audit.osha.index'))
            ->assertOk();
    });

    it('keeps canonical employee routes accessible in overview mode', function (): void {
        $this->storeManager->update(['current_store_id' => null]);

        $this->actingAs($this->storeManager)
            ->get(route('dealer.employees.index'))
            ->assertOk();
    });
});
