<?php

declare(strict_types=1);

use App\Models\ComplianceScoreSnapshot;
use App\Models\Dealer\Store;
use App\Models\TenantComplianceSnapshot;
use Carbon\CarbonImmutable;

beforeEach(function (): void {
    CarbonImmutable::setTestNow('2026-06-15 09:00:00');
});

afterEach(function (): void {
    CarbonImmutable::setTestNow();
});

it('writes a ComplianceScoreSnapshot per store on first run', function (): void {
    $primary = Store::query()->firstOrFail();
    $second = Store::query()->create(['name' => 'Snap Store '.uniqid(), 'slug' => 'snap-'.uniqid()]);

    tenancy()->end();
    $this->artisan('compliance:snapshot-scores', ['--tenants' => [$this->tenant->id]])
        ->assertSuccessful();

    $this->tenant->run(function () use ($primary, $second): void {
        $today = CarbonImmutable::now()->toDateString();

        foreach ([$primary, $second] as $store) {
            $row = ComplianceScoreSnapshot::query()
                ->where('store_id', $store->id)
                ->where('scored_on', $today)
                ->first();

            expect($row)->not->toBeNull()
                ->and($row->score)->toBeFloat()
                ->and($row->pillars)->toBeArray()
                ->and($row->weights)->toBeArray();
        }
    });
});

it('upserts a TenantComplianceSnapshot row for the tenant total', function (): void {
    tenancy()->end();
    $this->artisan('compliance:snapshot-scores', ['--tenants' => [$this->tenant->id]])
        ->assertSuccessful();

    $this->tenant->run(function (): void {
        $today = CarbonImmutable::now()->toDateString();

        $row = TenantComplianceSnapshot::query()
            ->where('scored_on', $today)
            ->first();

        expect($row)->not->toBeNull()
            ->and($row->expired_training_count)->toBeInt()
            ->and($row->expiring_soon_training_count)->toBeInt();
    });
});

it('is idempotent on the same scored_on date', function (): void {
    tenancy()->end();
    $this->artisan('compliance:snapshot-scores', ['--tenants' => [$this->tenant->id]])->assertSuccessful();
    $this->artisan('compliance:snapshot-scores', ['--tenants' => [$this->tenant->id]])->assertSuccessful();

    $this->tenant->run(function (): void {
        $today = CarbonImmutable::now()->toDateString();
        $store = Store::query()->firstOrFail();

        expect(
            ComplianceScoreSnapshot::query()
                ->where('store_id', $store->id)
                ->where('scored_on', $today)
                ->count()
        )->toBe(1);

        expect(
            TenantComplianceSnapshot::query()
                ->where('scored_on', $today)
                ->count()
        )->toBe(1);
    });
});

it('refreshes the snapshot row when re-run with mutated state', function (): void {
    tenancy()->end();
    $this->artisan('compliance:snapshot-scores', ['--tenants' => [$this->tenant->id]])->assertSuccessful();

    // Tamper with the stored score so the second run has something to overwrite.
    $store = $this->tenant->run(fn (): Store => Store::query()->firstOrFail());
    $this->tenant->run(function () use ($store): void {
        ComplianceScoreSnapshot::query()
            ->where('store_id', $store->id)
            ->update(['score' => -99.0]);
    });

    $this->artisan('compliance:snapshot-scores', ['--tenants' => [$this->tenant->id]])->assertSuccessful();

    $this->tenant->run(function () use ($store): void {
        $today = CarbonImmutable::now()->toDateString();
        $row = ComplianceScoreSnapshot::query()
            ->where('store_id', $store->id)
            ->where('scored_on', $today)
            ->firstOrFail();

        expect($row->score)->not->toBe(-99.0);
    });
});
