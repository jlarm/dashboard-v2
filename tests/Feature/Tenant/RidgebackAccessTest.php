<?php

declare(strict_types=1);

use App\Models\Dealer\Store;

describe('ridgeback access', function (): void {
    it('redirects to dashboard when overview is selected for multi-store tenants', function (): void {
        $this->tenant->update(['locations' => true]);

        Store::query()->create([
            'name' => 'Second Ridgeback Store',
            'slug' => 'second-ridgeback-store',
        ]);

        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.ridgeback.index'))
            ->assertRedirect(route('dealer.dashboard'));
    });

    it('loads ridgeback page when a current store is selected', function (): void {
        $this->tenant->update(['locations' => true]);

        $store = Store::query()->firstOrFail();
        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.ridgeback.index'))
            ->assertOk();
    });
});
