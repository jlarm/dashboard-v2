<?php

declare(strict_types=1);

use App\Models\ComplianceScoreSnapshot;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
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
            ->has('overdue_remediations', fn (AssertableInertia $overdue) => $overdue
                ->has('count')
                ->has('high_severity_count')
                ->has('previous_count')
                ->has('delta_pct')
            )
        );
});

it('computes overdue_remediations.delta_pct from the prior month snapshot', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    ComplianceScoreSnapshot::query()->create([
        'store_id' => $store->id,
        'scored_on' => CarbonImmutable::now()->subMonth()->subDays(2)->toDateString(),
        'score' => 80.0,
        'pillars' => [],
        'weights' => [],
        'overdue_count' => 10,
        'overdue_high_severity_count' => 3,
    ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('overdue_remediations.previous_count', 10)
            ->where('overdue_remediations.count', 0)
            ->where('overdue_remediations.delta_pct', -100)
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
