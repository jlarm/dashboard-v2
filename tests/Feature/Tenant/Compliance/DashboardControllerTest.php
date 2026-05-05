<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use Inertia\Testing\AssertableInertia;

it('passes a compliance prop with score, delta, pillars, and caption to the dashboard', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('tenant/Dashboard')
            ->has('compliance', fn (AssertableInertia $compliance) => $compliance
                ->has('score')
                ->has('previous_score')
                ->has('delta')
                ->has('pillars')
                ->has('computed_at')
                ->has('caption')
            )
        );
});

it('returns an empty compliance payload when no stores are scoped', function (): void {
    Store::query()->delete();
    app()->instance('scopedStoreIds', collect());

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('tenant/Dashboard')
            ->where('compliance.score', null)
            ->where('compliance.pillars', [])
        );
})->skip('requires-store middleware blocks empty-store sessions; cover via unit-level controller test if needed.');
