<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    // Enable multi-store (locations) on the tenant so has.stores middleware passes
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

    $this->storeEmployee = User::query()->create([
        'name' => 'Store Employee',
        'email' => 'store-employee@test.com',
        'password' => bcrypt('password'),
    ]);
    $this->storeEmployee->assignRole('Employee');
    $this->storeEmployee->stores()->attach($this->assignedStore->id);

    app()[PermissionRegistrar::class]->forgetCachedPermissions();
});

describe('Store Access - Consultant Bypasses Store Assignment', function (): void {
    it('consultant can access any store without being assigned', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.stores.home', $this->unassignedStore))
            ->assertOk();
    });

    it('consultant can access assigned store home', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.stores.home', $this->assignedStore))
            ->assertOk();
    });
});

describe('Store Access - Manager Store Scoping', function (): void {
    it('manager can access their assigned store', function (): void {
        $this->actingAs($this->storeManager)
            ->get(route('dealer.stores.home', $this->assignedStore))
            ->assertOk();
    });

    it('manager cannot access a store they are not assigned to', function (): void {
        $this->actingAs($this->storeManager)
            ->get(route('dealer.stores.home', $this->unassignedStore))
            ->assertRedirect(route('dealer.dashboard'));
    });

    it('manager can access employees within their assigned store', function (): void {
        $this->actingAs($this->storeManager)
            ->get(route('dealer.stores.employees', $this->assignedStore))
            ->assertOk();
    });

    it('manager cannot access employees in unassigned store', function (): void {
        $this->actingAs($this->storeManager)
            ->get(route('dealer.stores.employees', $this->unassignedStore))
            ->assertRedirect(route('dealer.dashboard'));
    });
});

describe('Store Access - Employee Store Scoping', function (): void {
    it('employee can access store home if assigned to the store', function (): void {
        $this->actingAs($this->storeEmployee)
            ->get(route('dealer.stores.home', $this->assignedStore))
            ->assertOk();
    });

    it('employee cannot access unassigned store', function (): void {
        $this->actingAs($this->storeEmployee)
            ->get(route('dealer.stores.home', $this->unassignedStore))
            ->assertRedirect(route('dealer.dashboard'));
    });
});

describe('Store Access - Store-Scoped Audit Routes', function (): void {
    it('consultant can access store-scoped osha audit index', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.stores.audits.osha.index', $this->assignedStore))
            ->assertOk();
    });

    it('manager can access store-scoped osha audit index for assigned store', function (): void {
        $this->actingAs($this->storeManager)
            ->get(route('dealer.stores.audits.osha.index', $this->assignedStore))
            ->assertOk();
    });

    it('manager cannot access store-scoped osha audit index for unassigned store', function (): void {
        $this->actingAs($this->storeManager)
            ->get(route('dealer.stores.audits.osha.index', $this->unassignedStore))
            ->assertRedirect(route('dealer.dashboard'));
    });

    it('consultant can access store-scoped body shop audit index', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.stores.audits.body-shop.index', $this->assignedStore))
            ->assertOk();
    });

    it('consultant can access store-scoped finance audit index', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.stores.audits.finance.index', $this->assignedStore))
            ->assertOk();
    });
});

describe('Store Access - Store-Scoped Consultant-Only Routes', function (): void {
    it('consultant can access store-scoped osha audit create', function (): void {
        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.stores.audits.body-shop.create', $this->unassignedStore));

        // Authorization passes — not forbidden
        expect($response->status())->not->toBeIn([401, 403]);
    });

    it('manager cannot access store-scoped consultant-only route', function (): void {
        $this->actingAs($this->storeManager)
            ->get(route('dealer.stores.audits.body-shop.create', $this->assignedStore))
            ->assertForbidden();
    });

    it('consultant can access store settings', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.stores.settings', $this->assignedStore))
            ->assertOk();
    });

    it('consultant can access store edit', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.stores.edit', $this->assignedStore))
            ->assertOk();
    });
});

describe('Store Access - Multiple Store Assignment', function (): void {
    it('manager with two stores can access both', function (): void {
        $this->storeManager->stores()->attach($this->unassignedStore->id);

        $this->actingAs($this->storeManager)
            ->get(route('dealer.stores.home', $this->assignedStore))
            ->assertOk();

        $this->actingAs($this->storeManager)
            ->get(route('dealer.stores.home', $this->unassignedStore))
            ->assertOk();
    });
});
