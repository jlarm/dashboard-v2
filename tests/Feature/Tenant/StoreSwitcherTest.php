<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use App\Http\Livewire\Dealer\Navigation\StoreSwitcher;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Livewire;

describe('StoreSwitcher Component', function (): void {
    it('renders successfully', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(StoreSwitcher::class)
            ->assertStatus(200);
    });

    it('displays "Select a Store" when no store is selected', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(StoreSwitcher::class)
            ->assertSee('Select a Store');
    });

    it('displays the current store name when a store is passed', function (): void {
        $store = Store::query()->first();

        $this->actingAs($this->consultant);

        $request = Request::create('/test');
        $request->attributes->set('store', $store);

        Livewire::test(StoreSwitcher::class, ['request' => $request])
            ->assertSee($store->name);
    });

    it('displays truncated store name if too long', function (): void {
        $longStoreName = 'This is a very long store name that should be truncated';
        $store = Store::query()->create([
            'name' => $longStoreName,
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);

        $request = Request::create('/test');
        $request->attributes->set('store', $store);

        Livewire::test(StoreSwitcher::class, ['request' => $request])
            ->assertSee('This is a very long store name...');
    });
});

describe('Store Listing', function (): void {
    it('shows only user stores for regular users', function (): void {
        $user = User::query()->create([
            'name' => 'Regular User',
            'email' => 'regular@test.com',
            'password' => bcrypt('password'),
        ]);

        $userStore1 = Store::query()->create([
            'name' => 'User Store 1',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $userStore2 = Store::query()->create([
            'name' => 'User Store 2',
            'address' => '456 Oak Ave',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $otherStore = Store::query()->create([
            'name' => 'Other Store',
            'address' => '789 Elm St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $user->stores()->attach([$userStore1->id, $userStore2->id]);

        $this->actingAs($user);

        Livewire::test(StoreSwitcher::class)
            ->assertSee('User Store 1')
            ->assertSee('User Store 2')
            ->assertDontSee('Other Store');
    });

    it('shows all stores for consultant users', function (): void {
        $store1 = Store::query()->create([
            'name' => 'Store A',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $store2 = Store::query()->create([
            'name' => 'Store B',
            'address' => '456 Oak Ave',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);

        Livewire::test(StoreSwitcher::class)
            ->assertSee('Store A')
            ->assertSee('Store B');
    });

    it('orders stores alphabetically by name', function (): void {
        Store::query()->create([
            'name' => 'Zebra Store',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        Store::query()->create([
            'name' => 'Alpha Store',
            'address' => '456 Oak Ave',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        Store::query()->create([
            'name' => 'Beta Store',
            'address' => '789 Elm St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);

        $component = Livewire::test(StoreSwitcher::class);
        $stores = $component->get('stores');

        expect($stores->pluck('name')->toArray())->toBe([
            'Alpha Store',
            'Beta Store',
            'Test Store',
            'Zebra Store',
        ]);
    });
});

describe('All Stores Link', function (): void {
    it('shows "All Stores" link when user has multiple stores and is in a store context', function (): void {
        $user = User::query()->create([
            'name' => 'Multi Store User',
            'email' => 'multi@test.com',
            'password' => bcrypt('password'),
        ]);

        $store1 = Store::query()->create([
            'name' => 'Store 1',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $store2 = Store::query()->create([
            'name' => 'Store 2',
            'address' => '456 Oak Ave',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $user->stores()->attach([$store1->id, $store2->id]);

        $this->actingAs($user);

        $request = Request::create('/test');
        $request->attributes->set('store', $store1);

        Livewire::test(StoreSwitcher::class, ['request' => $request])
            ->assertSee('All Stores');
    });

    it('does not show "All Stores" link when user has only one store', function (): void {
        $user = User::query()->create([
            'name' => 'Single Store User',
            'email' => 'single@test.com',
            'password' => bcrypt('password'),
        ]);

        $store = Store::query()->create([
            'name' => 'Single Store',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $user->stores()->attach($store->id);

        $this->actingAs($user);

        $request = Request::create('/test');
        $request->attributes->set('store', $store);

        Livewire::test(StoreSwitcher::class, ['request' => $request])
            ->assertDontSee('All Stores');
    });

    it('does not show "All Stores" link when not in a store context', function (): void {
        $user = User::query()->create([
            'name' => 'Dashboard User',
            'email' => 'dashboard@test.com',
            'password' => bcrypt('password'),
        ]);

        $store1 = Store::query()->create([
            'name' => 'Store 1',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $store2 = Store::query()->create([
            'name' => 'Store 2',
            'address' => '456 Oak Ave',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $user->stores()->attach([$store1->id, $store2->id]);

        $this->actingAs($user);

        Livewire::test(StoreSwitcher::class)
            ->assertDontSee('All Stores');
    });
});

describe('Component Refresh', function (): void {
    it('refreshes when "refreshStores" event is emitted', function (): void {
        $user = User::query()->create([
            'name' => 'Refresh Test User',
            'email' => 'refresh@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $component = Livewire::test(StoreSwitcher::class);

        // Create a new store after component is loaded
        $newStore = Store::query()->create([
            'name' => 'New Store',
            'address' => '999 New St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $user->stores()->attach($newStore->id);

        // Emit the refresh event
        $component->emit('refreshStores')
            ->assertSee('New Store');
    });
});

describe('Computed Properties', function (): void {
    it('has stores computed property', function (): void {
        $user = User::query()->create([
            'name' => 'Props Test User',
            'email' => 'props@test.com',
            'password' => bcrypt('password'),
        ]);

        $store = Store::query()->create([
            'name' => 'Test Store Props',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $user->stores()->attach($store->id);

        $this->actingAs($user);

        $component = Livewire::test(StoreSwitcher::class);
        $stores = $component->get('stores');

        expect($stores)->toBeInstanceOf(Collection::class);
        expect($stores)->toHaveCount(1);
    });

    it('has currentStoreDisplay computed property', function (): void {
        $this->actingAs($this->consultant);

        $component = Livewire::test(StoreSwitcher::class);
        $display = $component->get('currentStoreDisplay');

        expect($display)->toBe('Select a Store');
    });
});
