<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\CalculateViolationsOverview;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use App\Models\Remediation;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;

it('returns six empty buckets for every granularity when no stores are scoped', function (): void {
    $now = CarbonImmutable::create(2026, 5, 15);

    $result = (new CalculateViolationsOverview())->handleForStores([], $now);

    expect($result->monthly)->toHaveCount(6);
    expect($result->quarterly)->toHaveCount(6);
    expect($result->yearly)->toHaveCount(6);

    foreach ($result->monthly as $bucket) {
        expect($bucket['opened'])->toBe(0);
        expect($bucket['closed'])->toBe(0);
    }
});

it('attributes opens to the audit completed_date bucket and closes to the remediation completed_date bucket', function (): void {
    $store = Store::query()->firstOrFail();
    $now = CarbonImmutable::create(2026, 5, 15);

    $oldAudit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => $now->subMonths(2),
        'grade' => 'A',
        'completed_date' => $now->subMonths(2)->setDay(10), // March
    ]);

    [$violation] = collect([
        ['statement' => 'A', 'severity' => 5],
        ['statement' => 'B', 'severity' => 3],
    ])->map(fn (array $row): Violation => $oldAudit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => $row['statement'],
        'severity' => $row['severity'],
    ]))->all();

    Remediation::query()->create([
        'violation_id' => $violation->id,
        'user_id' => $this->consultant->id,
        'comment' => 'Resolved',
        'completed' => true,
        'completed_date' => $now->setDay(2), // May (closed two months later)
    ]);

    $result = (new CalculateViolationsOverview())->handleForStores([$store->id], $now);

    $byLabel = collect($result->monthly)->keyBy('label');

    // Opens land in March (audit completed); closes land in May (remediation completed).
    expect($byLabel->get('Mar')['opened'])->toBe(2);
    expect($byLabel->get('Mar')['closed'])->toBe(0);
    expect($byLabel->get('May')['opened'])->toBe(0);
    expect($byLabel->get('May')['closed'])->toBe(1);
});

it('aggregates across audit types', function (): void {
    $store = Store::query()->firstOrFail();
    $now = CarbonImmutable::create(2026, 5, 15);

    $osha = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => $now->setDay(2),
        'grade' => 'A',
        'completed_date' => $now->setDay(2),
    ]);
    $osha->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => 'OSHA',
        'severity' => 5,
    ]);

    $bodyShop = BodyShopViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => $now->setDay(3),
        'grade' => 'A',
        'completed_date' => $now->setDay(3),
    ]);
    $bodyShop->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => 'BS-1',
        'severity' => 5,
    ]);
    $bodyShop->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => 'BS-2',
        'severity' => 5,
    ]);

    $result = (new CalculateViolationsOverview())->handleForStores([$store->id], $now);

    $may = collect($result->monthly)->firstWhere('label', 'May');
    expect($may['opened'])->toBe(3);
});

it('only includes audits owned by stores in the scope', function (): void {
    $storeA = Store::query()->firstOrFail();
    $storeB = Store::query()->create(['name' => 'Other '.uniqid(), 'slug' => 'other-'.uniqid()]);
    $now = CarbonImmutable::create(2026, 5, 15);

    foreach ([$storeA, $storeB] as $store) {
        $audit = OshaViolationAudit::query()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $this->consultant->id,
            'store_id' => $store->id,
            'date' => $now->setDay(2),
            'grade' => 'A',
            'completed_date' => $now->setDay(2),
        ]);
        $audit->violations()->create([
            'uuid' => (string) Str::uuid(),
            'statement_id' => 1,
            'statement' => 'V',
            'severity' => 5,
        ]);
    }

    $resultA = (new CalculateViolationsOverview())->handleForStores([$storeA->id], $now);
    $resultBoth = (new CalculateViolationsOverview())->handleForStores([$storeA->id, $storeB->id], $now);

    expect(collect($resultA->monthly)->firstWhere('label', 'May')['opened'])->toBe(1);
    expect(collect($resultBoth->monthly)->firstWhere('label', 'May')['opened'])->toBe(2);
});

it('emits six period rows for each granularity', function (): void {
    $now = CarbonImmutable::create(2026, 5, 15);

    $result = (new CalculateViolationsOverview())->handleForStores([Store::query()->firstOrFail()->id], $now);

    expect($result->monthly)->toHaveCount(6);
    expect($result->monthly[5]['label'])->toBe('May');

    expect($result->quarterly)->toHaveCount(6);
    expect($result->quarterly[5]['label'])->toBe('Q2 26');

    expect($result->yearly)->toHaveCount(6);
    expect($result->yearly[5]['label'])->toBe('2026');
});
