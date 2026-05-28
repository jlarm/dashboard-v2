<?php

declare(strict_types=1);

use App\Models\Dealer\Store;

describe('first store enforcement', function (): void {
    it('shows first store form on dashboard and disables navigation when tenant has no stores', function (): void {
        Store::query()->delete();
        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.dashboard'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/Dashboard')
                ->has('stores', 0)
                ->where('audit_quick_start_store_id', null)
            );
    });

    it('redirects other tenant pages to dashboard when tenant has no stores', function (): void {
        Store::query()->delete();
        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.index'))
            ->assertRedirect(route('dealer.dashboard'));
    });

    it('creates first store from dashboard form and assigns user store context', function (): void {
        Store::query()->delete();
        $this->consultant->update(['current_store_id' => null]);
        $this->manager->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->post(route('dealer.store.first'), [
                'name' => 'First Tenant Store',
                'address' => '123 Main St',
                'city' => 'Nashville',
                'state' => 'TN',
                'postal_code' => '37201',
                'phone' => '615-555-0101',
                'website' => 'https://first-store.example.com',
            ])
            ->assertRedirect(route('dealer.dashboard'));

        $store = Store::query()->where('name', 'First Tenant Store')->firstOrFail();

        expect($this->consultant->fresh()->current_store_id)->toBe($store->id);
        expect($this->manager->fresh()->current_store_id)->toBe($store->id);
        expect($this->manager->fresh()->stores()->where('stores.id', $store->id)->exists())->toBeTrue();
    });
});
