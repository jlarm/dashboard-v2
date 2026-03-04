<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Layout\CurrentStoreName;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Livewire;

describe('current store name switcher', function (): void {
    it('renders a coach mark for users assigned to multiple stores', function (): void {
        $secondStore = Store::query()->create([
            'name' => 'Second Store',
            'address' => '22 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $primaryStore = Store::query()->firstOrFail();

        $this->manager->stores()->attach([$primaryStore->id, $secondStore->id]);

        $this->actingAs($this->manager);
        $this->manager->update(['current_store_id' => null]);

        Livewire::test(CurrentStoreName::class)
            ->assertSee('combobox')
            ->assertSee('Test Dealership')
            ->assertSee('Overview')
            ->assertSee('Second Store')
            ->assertSee('Store switching moved here')
            ->assertSee('Use this menu any time you need to jump between your stores.');
    });

    it('does not render the coach mark for users with role-based access but no multi-store assignment', function (): void {
        Store::query()->create([
            'name' => 'Second Store',
            'address' => '22 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => null]);

        Livewire::test(CurrentStoreName::class)
            ->assertSee('combobox')
            ->assertDontSee('Store switching moved here');
    });

    it('renders a disabled switcher without dropdown icon for users with one accessible store', function (): void {
        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => null]);

        Livewire::test(CurrentStoreName::class)
            ->assertSee('current-store-combobox')
            ->assertSee('Test Store')
            ->assertSeeHtml('disabled')
            ->assertDontSee('data-switcher-icon')
            ->assertDontSee('Store switching moved here');
    });

    it('updates current_store_id and redirects when selecting a store', function (): void {
        $store = Store::query()->firstOrFail();

        Store::query()->create([
            'name' => 'Selectable Store',
            'address' => '33 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $referrer = route('dealer.employees.index');

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => null]);
        $this->from($referrer);

        Livewire::test(CurrentStoreName::class)
            ->call('switchStore', $store->id)
            ->assertRedirect($referrer);

        expect($this->consultant->fresh()->current_store_id)->toBe($store->id);
    });

    it('disables the active selection in the current store dropdown', function (): void {
        $store = Store::query()->firstOrFail();

        Store::query()->create([
            'name' => 'Current Store Disabled Target',
            'address' => '33A Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => $store->id]);

        Livewire::test(CurrentStoreName::class)
            ->assertSee('aria-disabled="true"', false)
            ->assertSee('disabled', false);
    });

    it('redirects to the audit index path when switching stores from an audit detail route', function (): void {
        $store = Store::query()->firstOrFail();

        Store::query()->create([
            'name' => 'Audit Redirect Store',
            'address' => '34 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $referrer = url('/audits/finance/3bb86ce9-af5d-4271-ada8-c97ba750b6f9/edit');

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => null]);
        $this->from($referrer);

        Livewire::test(CurrentStoreName::class)
            ->call('switchStore', $store->id)
            ->assertRedirect(url('/audits/finance'));

        expect($this->consultant->fresh()->current_store_id)->toBe($store->id);
    });

    it('redirects to the employees index path when switching stores from an employee profile route', function (): void {
        $store = Store::query()->firstOrFail();

        Store::query()->create([
            'name' => 'Employee Redirect Store',
            'address' => '35 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $referrer = url('/employees/alice-diaz');

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => null]);
        $this->from($referrer);

        Livewire::test(CurrentStoreName::class)
            ->call('switchStore', $store->id)
            ->assertRedirect(url('/employees'));

        expect($this->consultant->fresh()->current_store_id)->toBe($store->id);
    });

    it('redirects to settings when switching to a store from global settings as super-admin', function (): void {
        tenant()->update(['locations' => true]);

        $superAdmin = User::query()->create([
            'name' => 'Current Name Global Super Admin',
            'email' => 'current-name-global-super-admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        $store = Store::query()->firstOrFail();

        Store::query()->create([
            'name' => 'Current Name Global Second Store',
            'address' => '36 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($superAdmin);
        $superAdmin->update(['current_store_id' => null]);
        $this->from(route('dealer.settings.global'));

        Livewire::test(CurrentStoreName::class)
            ->call('switchStore', $store->id)
            ->assertRedirect(route('dealer.dealer.settings'));

        expect($superAdmin->fresh()->current_store_id)->toBe($store->id);
    });

    it('sets current_store_id to null and redirects scans to dashboard for overview', function (): void {
        $store = Store::query()->firstOrFail();

        Store::query()->create([
            'name' => 'Overview Store',
            'address' => '44 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => $store->id]);
        $this->from(route('dealer.scan.index'));

        Livewire::test(CurrentStoreName::class)
            ->call('switchToOverview')
            ->assertRedirect(route('dealer.dashboard'));

        expect($this->consultant->fresh()->current_store_id)->toBeNull();
    });

    it('ignores switching to the currently active store from the current store dropdown', function (): void {
        $store = Store::query()->firstOrFail();

        Store::query()->create([
            'name' => 'Current Store Same Selection Guard',
            'address' => '44A Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($this->consultant);
        $this->consultant->update(['current_store_id' => $store->id]);

        Livewire::test(CurrentStoreName::class)
            ->call('switchStore', $store->id);

        expect($this->consultant->fresh()->current_store_id)->toBe($store->id);
    });

    it('redirects to global settings when switching to overview from settings as super-admin', function (): void {
        tenant()->update(['locations' => true]);

        $superAdmin = User::query()->create([
            'name' => 'Current Name Super Admin',
            'email' => 'current-name-super-admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        $store = Store::query()->firstOrFail();

        Store::query()->create([
            'name' => 'Current Name Second Store',
            'address' => '45 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $this->actingAs($superAdmin);
        $superAdmin->update(['current_store_id' => $store->id]);
        $this->from(route('dealer.dealer.settings'));

        Livewire::test(CurrentStoreName::class)
            ->call('switchToOverview')
            ->assertRedirect(route('dealer.settings.global'));

        expect($superAdmin->fresh()->current_store_id)->toBeNull();
    });
});
