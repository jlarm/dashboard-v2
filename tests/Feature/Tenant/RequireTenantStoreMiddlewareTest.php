<?php

declare(strict_types=1);

use App\Models\Dealer\Store;

describe('require tenant store middleware', function (): void {
    it('allows dashboard when no stores exist', function (): void {
        Store::query()->delete();
        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.dashboard'))
            ->assertOk();
    });

    it('redirects authenticated users to dashboard for protected pages when no stores exist', function (): void {
        Store::query()->delete();
        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.locations.index'))
            ->assertRedirect(route('dealer.dashboard'));
    });

    it('allows protected pages when at least one store exists', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.locations.index'))
            ->assertOk();
    });
});
