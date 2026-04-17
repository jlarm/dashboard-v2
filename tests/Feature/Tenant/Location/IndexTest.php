<?php

declare(strict_types=1);

use App\Http\Livewire\Tenant\Location\EditStoreModal;
use App\Http\Livewire\Tenant\Location\Index as LocationIndex;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Livewire;

describe('tenant locations index', function (): void {
    it('shows add location action for super-admin users', function (): void {
        $superAdmin = User::query()->create([
            'name' => 'Location Super Admin',
            'email' => 'location-super-admin@test-tenant.localhost',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        $this->actingAs($superAdmin)
            ->get(route('dealer.locations.index'))
            ->assertOk()
            ->assertSee('Add Location');
    });

    it('lists all stores with name city and state', function (): void {
        $firstStore = Store::query()->firstOrFail();
        $firstStore->update([
            'city' => 'Detroit',
            'state' => 'MI',
        ]);

        $secondStore = Store::query()->create([
            'name' => 'Northwest Motors',
            'address' => '101 Main St',
            'city' => 'Seattle',
            'state' => 'WA',
            'postal_code' => '98101',
            'phone' => '206-555-0101',
            'website' => 'https://northwest.example.com',
        ]);

        $this->actingAs($this->consultant);

        Livewire::test(LocationIndex::class)
            ->assertSee($firstStore->name)
            ->assertSee('Detroit')
            ->assertSee('MI')
            ->assertSee($secondStore->name)
            ->assertSee('Seattle')
            ->assertSee('WA')
            ->assertSee('Edit');
    });

    it('emits an edit modal open event for the selected store', function (): void {
        $store = Store::query()->firstOrFail();

        $this->actingAs($this->consultant);

        Livewire::test(LocationIndex::class)
            ->call('openEditModal', $store->id)
            ->assertDispatched('modal.open', 'tenant.location.edit-store-modal', ['storeId' => $store->id]);
    });

    it('updates store details from the edit modal', function (): void {
        $store = Store::query()->firstOrFail();
        $store->update([
            'address' => '10 Old Rd',
            'city' => 'Austin',
            'state' => 'TX',
            'postal_code' => '73301',
            'phone' => '512-555-1234',
            'website' => 'https://old.example.com',
        ]);

        $this->actingAs($this->consultant);

        Livewire::test(EditStoreModal::class, ['storeId' => $store->id])
            ->set('name', 'Updated Location Name')
            ->set('address', '88 New Road')
            ->set('city', 'Columbus')
            ->set('state', 'OH')
            ->set('postal_code', '43215')
            ->set('phone', '614-555-0000')
            ->set('website', 'https://updated.example.com')
            ->call('updateStore')
            ->assertHasNoErrors()
            ->assertDispatched('refreshLocations');

        expect($store->fresh())
            ->name->toBe('Updated Location Name')
            ->address->toBe('88 New Road')
            ->city->toBe('Columbus')
            ->state->toBe('OH')
            ->postal_code->toBe('43215')
            ->phone->toBe('614-555-0000')
            ->website->toBe('https://updated.example.com');
    });
});
