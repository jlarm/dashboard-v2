<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Navigation\StoreSwitcher;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Livewire;

describe('store switcher component', function (): void {
    it('renders successfully', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(StoreSwitcher::class)
            ->assertOk();
    });

    it('shows overview when current_store_id is null', function (): void {
        Store::query()->create([
            'name' => 'Overview Visible Store',
            'address' => '101 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => null]);

        Livewire::test(StoreSwitcher::class)
            ->assertSee('Overview');
    });

    it('shows selected store name when current_store_id is set', function (): void {
        $store = Store::query()->firstOrFail();
        Store::query()->create([
            'name' => 'Second Visible Store',
            'address' => '333 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => $store->id]);

        Livewire::test(StoreSwitcher::class)
            ->assertSee($store->name);
    });

    it('disables the active store selection in the dropdown', function (): void {
        $store = Store::query()->firstOrFail();

        Store::query()->create([
            'name' => 'Third Visible Store',
            'address' => '444 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => $store->id]);

        Livewire::test(StoreSwitcher::class)
            ->assertSee('aria-disabled="true"', false)
            ->assertSee('disabled', false);
    });

    it('shows only assigned stores for regular users', function (): void {
        $user = User::query()->create([
            'name' => 'Regular User',
            'email' => 'regular@test.com',
            'password' => bcrypt('password'),
        ]);

        $assignedStore = Store::query()->create([
            'name' => 'Assigned Store',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $secondAssignedStore = Store::query()->create([
            'name' => 'Second Assigned Store',
            'address' => '456 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $otherStore = Store::query()->create([
            'name' => 'Other Store',
            'address' => '789 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $user->stores()->attach([$assignedStore->id, $secondAssignedStore->id]);
        $user->update(['current_store_id' => $assignedStore->id]);

        $this->actingAs($user);

        Livewire::test(StoreSwitcher::class)
            ->assertSee('Assigned Store')
            ->assertSee('Second Assigned Store')
            ->assertDontSee('Other Store');
    });

    it('shows all stores for consultant users', function (): void {
        $storeA = Store::query()->create([
            'name' => 'Store A',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $storeB = Store::query()->create([
            'name' => 'Store B',
            'address' => '456 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);

        Livewire::test(StoreSwitcher::class)
            ->assertSee($storeA->name)
            ->assertSee($storeB->name);
    });

    it('shows all stores for super-admin users', function (): void {
        $superAdmin = User::query()->create([
            'name' => 'Super Admin User',
            'email' => 'super-admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $superAdmin->assignRole('super-admin');

        $storeA = Store::query()->create([
            'name' => 'Super Store A',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $storeB = Store::query()->create([
            'name' => 'Super Store B',
            'address' => '456 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($superAdmin);

        Livewire::test(StoreSwitcher::class)
            ->assertSee($storeA->name)
            ->assertSee($storeB->name);
    });

    it('shows the overview option only when user has access to multiple stores', function (): void {
        $this->actingAs($this->consultant);

        Store::query()->create([
            'name' => 'Second Store',
            'address' => '789 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        Livewire::test(StoreSwitcher::class)
            ->assertSee('Overview');
    });

    it('does not render the switcher for users with only one accessible store', function (): void {
        $user = User::query()->create([
            'name' => 'Single Store User',
            'email' => 'single@test.com',
            'password' => bcrypt('password'),
        ]);

        $store = Store::query()->create([
            'name' => 'Only Store',
            'address' => '101 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $user->stores()->attach($store->id);
        $user->update(['current_store_id' => $store->id]);

        $this->actingAs($user);

        Livewire::test(StoreSwitcher::class)
            ->assertDontSee('Only Store')
            ->assertDontSee('Overview')
            ->assertDontSee('combobox');
    });

    it('does not render the switcher for consultant when tenant has one store', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(StoreSwitcher::class)
            ->assertDontSee('Overview')
            ->assertDontSee('combobox');
    });

    it('updates current_store_id and redirects when selecting a store', function (): void {
        $store = Store::query()->firstOrFail();
        $referrer = route('dealer.employees.index');

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => null]);
        $this->from($referrer);

        Livewire::test(StoreSwitcher::class)
            ->call('switchStore', $store->id)
            ->assertRedirect($referrer);

        expect($this->consultant->fresh()->current_store_id)->toBe($store->id);
    });

    it('redirects to the audit index path when switching stores from an audit detail route', function (): void {
        $store = Store::query()->firstOrFail();
        Store::query()->create([
            'name' => 'Store Redirect Target',
            'address' => '334 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $referrer = url('/audits/finance/3bb86ce9-af5d-4271-ada8-c97ba750b6f9/edit');

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => null]);
        $this->from($referrer);

        Livewire::test(StoreSwitcher::class)
            ->call('switchStore', $store->id)
            ->assertRedirect(url('/audits/finance'));

        expect($this->consultant->fresh()->current_store_id)->toBe($store->id);
    });

    it('redirects to the employees index path when switching stores from an employee profile route', function (): void {
        $store = Store::query()->firstOrFail();
        Store::query()->create([
            'name' => 'Employee Route Store',
            'address' => '335 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $referrer = url('/employees/alice-diaz');

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => null]);
        $this->from($referrer);

        Livewire::test(StoreSwitcher::class)
            ->call('switchStore', $store->id)
            ->assertRedirect(url('/employees'));

        expect($this->consultant->fresh()->current_store_id)->toBe($store->id);
    });

    it('redirects to settings when switching to a store from global settings as super-admin', function (): void {
        tenant()->update(['locations' => true]);

        $superAdmin = User::query()->create([
            'name' => 'Global Settings Super Admin',
            'email' => 'global-settings-super-admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        $store = Store::query()->firstOrFail();
        Store::query()->create([
            'name' => 'Store Settings Redirect Target',
            'address' => '336 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($superAdmin);
        $superAdmin->update(['current_store_id' => null]);
        $this->from(route('dealer.settings.global'));

        Livewire::test(StoreSwitcher::class)
            ->call('switchStore', $store->id)
            ->assertRedirect(route('dealer.dealer.settings'));

        expect($superAdmin->fresh()->current_store_id)->toBe($store->id);
    });

    it('sets current_store_id to null when switching to overview', function (): void {
        $store = Store::query()->firstOrFail();
        $referrer = route('dealer.employees.index');
        Store::query()->create([
            'name' => 'Overview Store',
            'address' => '500 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => $store->id]);
        $this->from($referrer);

        Livewire::test(StoreSwitcher::class)
            ->call('switchToOverview')
            ->assertRedirect($referrer);

        expect($this->consultant->fresh()->current_store_id)->toBeNull();
    });

    it('ignores switching to the currently active store', function (): void {
        $store = Store::query()->firstOrFail();

        Store::query()->create([
            'name' => 'Same Store Guard Target',
            'address' => '502 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => $store->id]);

        Livewire::test(StoreSwitcher::class)
            ->call('switchStore', $store->id);

        expect($this->consultant->fresh()->current_store_id)->toBe($store->id);
    });

    it('redirects to dashboard when switching to overview from a scans page', function (): void {
        tenant()->update(['locations' => true]);

        $store = Store::query()->firstOrFail();
        $referrer = route('dealer.scan.index');

        Store::query()->create([
            'name' => 'Overview Scans Store',
            'address' => '501 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => $store->id]);
        $this->from($referrer);

        Livewire::test(StoreSwitcher::class)
            ->call('switchToOverview')
            ->assertRedirect(route('dealer.dashboard'));

        expect($this->consultant->fresh()->current_store_id)->toBeNull();
    });

    it('redirects to global settings when switching to overview from settings as super-admin', function (): void {
        tenant()->update(['locations' => true]);

        $superAdmin = User::query()->create([
            'name' => 'Settings Super Admin',
            'email' => 'settings-super-admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        $store = Store::query()->firstOrFail();

        Store::query()->create([
            'name' => 'Second Super Admin Store',
            'address' => '505 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($superAdmin);
        $superAdmin->update(['current_store_id' => $store->id]);
        $this->from(route('dealer.dealer.settings'));

        Livewire::test(StoreSwitcher::class)
            ->call('switchToOverview')
            ->assertRedirect(route('dealer.settings.global'));

        expect($superAdmin->fresh()->current_store_id)->toBeNull();
    });

    it('exposes stores computed property', function (): void {
        $user = User::query()->create([
            'name' => 'Props Test User',
            'email' => 'props@test.com',
            'password' => bcrypt('password'),
        ]);

        $store = Store::query()->create([
            'name' => 'Props Store',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $user->stores()->attach($store->id);
        $user->update(['current_store_id' => $store->id]);

        $this->actingAs($user);

        $component = Livewire::test(StoreSwitcher::class);
        $stores = $component->get('stores');

        expect($stores)->toBeInstanceOf(Collection::class);
        expect($stores)->toHaveCount(1);
    });
});
