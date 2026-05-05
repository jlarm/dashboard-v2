<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\CalculateAuditPillar;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;

it('scores a recent A-grade audit with no outstanding remediations at 100', function (): void {
    $store = Store::query()->firstOrFail();

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => CarbonImmutable::now()->subMonth(),
        'grade' => 'A',
    ]);

    BodyShopViolationAuditFactoryHelper($store, $this->consultant);
    GlbaViolationAuditFactoryHelper($store, $this->consultant);

    $pillar = (new CalculateAuditPillar())->handle($store, CarbonImmutable::now());

    expect($pillar->applicable)->toBeTrue();
    expect($pillar->score)->toBe(100.0);
    expect($pillar->breakdown['types']['osha']['has_audit'])->toBeTrue();
    expect($pillar->breakdown['types']['osha']['stale'])->toBeFalse();
});

it('penalizes outstanding remediations weighted by severity', function (): void {
    $store = Store::query()->firstOrFail();

    $audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => CarbonImmutable::now()->subMonth(),
        'grade' => 'A',
    ]);

    foreach ([3, 2] as $severity) {
        $audit->violations()->create([
            'uuid' => (string) Str::uuid(),
            'statement_id' => 1,
            'statement' => 'Test',
            'severity' => $severity,
        ]);
    }

    BodyShopViolationAuditFactoryHelper($store, $this->consultant);
    GlbaViolationAuditFactoryHelper($store, $this->consultant);

    $pillar = (new CalculateAuditPillar())->handle($store, CarbonImmutable::now());

    // OSHA pillar: 100 - (3*4 + 2*4) = 80; averaged with two A-100 audits → (80+100+100)/3 ≈ 93.3
    expect($pillar->breakdown['types']['osha']['outstanding_remediations'])->toBe(2);
    expect($pillar->breakdown['types']['osha']['score'])->toBe(80.0);
    expect($pillar->score)->toEqualWithDelta(93.3, 0.1);
});

it('caps a stale audit at the staleness fallback', function (): void {
    $store = Store::query()->firstOrFail();

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => CarbonImmutable::now()->subMonths(18),
        'grade' => 'A',
    ]);

    BodyShopViolationAuditFactoryHelper($store, $this->consultant);
    GlbaViolationAuditFactoryHelper($store, $this->consultant);

    $pillar = (new CalculateAuditPillar())->handle($store, CarbonImmutable::now());

    expect($pillar->breakdown['types']['osha']['stale'])->toBeTrue();
    expect($pillar->breakdown['types']['osha']['score'])->toBe(50.0);
});

it('treats a store with no audits as fully stale', function (): void {
    $store = Store::query()->firstOrFail();

    $pillar = (new CalculateAuditPillar())->handle($store, CarbonImmutable::now());

    expect($pillar->score)->toBe(50.0);
    foreach (['osha', 'body_shop', 'glba'] as $key) {
        expect($pillar->breakdown['types'][$key]['has_audit'])->toBeFalse();
    }
});

function BodyShopViolationAuditFactoryHelper(Store $store, App\Models\User $user): void
{
    BodyShopViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $user->id,
        'store_id' => $store->id,
        'date' => CarbonImmutable::now()->subMonth(),
        'grade' => 'A',
    ]);
}

function GlbaViolationAuditFactoryHelper(Store $store, App\Models\User $user): void
{
    GlbaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $user->id,
        'store_id' => $store->id,
        'date' => CarbonImmutable::now()->subMonth(),
        'grade' => 'A',
    ]);
}
