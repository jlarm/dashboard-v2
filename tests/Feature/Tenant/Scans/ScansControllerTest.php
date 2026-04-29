<?php

declare(strict_types=1);

use App\Models\Dealer\Store;

beforeEach(function (): void {
    $this->store = Store::query()->first();
});

describe('GET scans (Inertia)', function (): void {
    it('renders the dashboard mode for a single-store consultant', function (): void {
        $this->consultant->update(['current_store_id' => $this->store->id]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/scans/Index')
                ->where('mode', 'dashboard')
                ->where('store.id', $this->store->id));
    });

    it('redirects to dashboard when current_store_id is null with multi-store locations enabled', function (): void {
        tenant()->update(['locations' => true]);

        Store::query()->create([
            'name' => 'Second Route Store',
            'slug' => 'second-route-store',
        ]);

        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.index'))
            ->assertRedirect(route('dealer.dashboard'));
    });
});
