<?php

declare(strict_types=1);

use App\Http\Livewire\Tenant\Location\CreateModal;
use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;
use App\Models\Dealer\StoreSettings;
use App\Models\User;
use Livewire\Livewire;

describe('tenant locations create modal', function (): void {
    it('allows consultants to create a new location and related records', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(CreateModal::class)
            ->set('name', 'Consultant Created Store')
            ->set('address', '123 Main St')
            ->set('city', 'Denver')
            ->set('state', 'CO')
            ->set('postal_code', '80202')
            ->set('phone', '303-555-0101')
            ->set('website', 'https://consultant-created.example.com')
            ->call('createStore')
            ->assertHasNoErrors()
            ->assertEmitted('refreshLocations');

        $store = Store::query()->where('name', 'Consultant Created Store')->first();

        expect($store)->not->toBeNull();
        expect(StoreSettings::query()->where('store_id', $store->id)->exists())->toBeTrue();
        expect(EmployeeList::query()->where('store_id', $store->id)->exists())->toBeTrue();
        expect(ScanSetting::query()->where('store_id', $store->id)->exists())->toBeTrue();
    });

    it('allows super-admin users to create a new location', function (): void {
        $superAdmin = User::query()->create([
            'name' => 'Super Admin',
            'email' => 'super-admin-locations@test-tenant.localhost',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        $this->actingAs($superAdmin);

        Livewire::test(CreateModal::class)
            ->set('name', 'Super Admin Created Store')
            ->set('address', '456 Main St')
            ->set('city', 'Phoenix')
            ->set('state', 'AZ')
            ->set('postal_code', '85001')
            ->set('phone', '602-555-0101')
            ->set('website', 'https://super-admin-created.example.com')
            ->call('createStore')
            ->assertHasNoErrors()
            ->assertEmitted('refreshLocations');

        expect(Store::query()->where('name', 'Super Admin Created Store')->exists())->toBeTrue();
    });

    it('forbids users without consultant or super-admin role from opening the create location modal', function (): void {
        $this->actingAs($this->manager);

        Livewire::test(CreateModal::class)
            ->assertForbidden();

        expect(Store::query()->where('name', 'Blocked Store')->exists())->toBeFalse();
    });

    it('auto assigns users to the first store and sets current store ids when creating the first location', function (): void {
        Store::query()->delete();

        $manager = User::query()->create([
            'name' => 'First Store Manager',
            'email' => 'first-store-manager@test-tenant.localhost',
            'password' => bcrypt('password'),
            'current_store_id' => null,
        ]);
        $manager->assignRole('Manager');

        $superAdmin = User::query()->create([
            'name' => 'First Store Super Admin',
            'email' => 'first-store-super-admin@test-tenant.localhost',
            'password' => bcrypt('password'),
            'current_store_id' => null,
        ]);
        $superAdmin->assignRole('super-admin');

        $this->consultant->update(['current_store_id' => null]);
        $this->actingAs($this->consultant);

        Livewire::test(CreateModal::class)
            ->set('name', 'First Tenant Store')
            ->set('address', '100 Main St')
            ->set('city', 'Nashville')
            ->set('state', 'TN')
            ->set('postal_code', '37201')
            ->set('phone', '615-555-0101')
            ->set('website', 'https://first-tenant-store.example.com')
            ->call('createStore')
            ->assertHasNoErrors();

        $store = Store::query()->where('name', 'First Tenant Store')->firstOrFail();

        expect($this->consultant->fresh()->current_store_id)->toBe($store->id);
        expect($manager->fresh()->current_store_id)->toBe($store->id);
        expect($manager->fresh()->stores()->where('stores.id', $store->id)->exists())->toBeTrue();
        expect($superAdmin->fresh()->current_store_id)->toBe($store->id);
    });
});
