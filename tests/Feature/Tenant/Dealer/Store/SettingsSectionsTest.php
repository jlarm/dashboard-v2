<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

it('renders the general settings page on the default settings route', function (): void {
    $this->actingAs($this->consultant)
        ->get(route('dealer.dealer.settings'))
        ->assertOk()
        ->assertSee('Dealership Name')
        ->assertSee('Managers')
        ->assertSee('Compliance');
});

it('renders the managers settings page on its own route', function (): void {
    $this->actingAs($this->consultant)
        ->get(route('dealer.dealer.settings.managers'))
        ->assertOk()
        ->assertSee('id="qi"', false)
        ->assertSee('id="owner_phone"', false);
});

it('renders the compliance settings page on its own route', function (): void {
    $this->actingAs($this->consultant)
        ->get(route('dealer.dealer.settings.compliance'))
        ->assertOk()
        ->assertSee('Police Emergency Phone Number')
        ->assertSee('Fire Emergency Phone Number');
});

it('renders the reset courses settings page for authorized users', function (): void {
    $store = Store::query()->firstOrFail();

    $superAdmin = User::query()->create([
        'name' => 'Reset Courses Super Admin',
        'email' => 'reset-courses-super-admin@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => $store->id,
    ]);
    $superAdmin->assignRole('super-admin');
    $superAdmin->stores()->sync([$store->id]);

    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    $this->actingAs($superAdmin)
        ->get(route('dealer.dealer.settings.reset-courses'))
        ->assertOk()
        ->assertSee('Reset Courses')
        ->assertSee($store->name);
});

it('renders the ridgeback settings page for authorized users', function (): void {
    $store = Store::query()->firstOrFail();

    $superAdmin = User::query()->create([
        'name' => 'Settings Super Admin',
        'email' => 'settings-super-admin@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => $store->id,
    ]);
    $superAdmin->assignRole('super-admin');
    $superAdmin->stores()->sync([$store->id]);

    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    $this->actingAs($superAdmin)
        ->get(route('dealer.dealer.settings.ridgeback'))
        ->assertOk()
        ->assertSee('IP Address')
        ->assertSee('Active');
});

it('forbids the ridgeback settings page for users without dealership creation access', function (): void {
    $store = Store::query()->firstOrFail();

    $qualifiedIndividual = User::query()->create([
        'name' => 'Settings Qualified Individual',
        'email' => 'settings-qi@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => $store->id,
    ]);
    $qualifiedIndividual->assignRole('Qualified Individual');
    $qualifiedIndividual->stores()->sync([$store->id]);

    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    $this->actingAs($qualifiedIndividual)
        ->get(route('dealer.dealer.settings.ridgeback'))
        ->assertForbidden();
});

it('forbids the reset courses settings page for users without dealership creation access', function (): void {
    $store = Store::query()->firstOrFail();

    $qualifiedIndividual = User::query()->create([
        'name' => 'Reset Courses Qualified Individual',
        'email' => 'reset-courses-qi@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => $store->id,
    ]);
    $qualifiedIndividual->assignRole('Qualified Individual');
    $qualifiedIndividual->stores()->sync([$store->id]);

    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    $this->actingAs($qualifiedIndividual)
        ->get(route('dealer.dealer.settings.reset-courses'))
        ->assertForbidden();
});
