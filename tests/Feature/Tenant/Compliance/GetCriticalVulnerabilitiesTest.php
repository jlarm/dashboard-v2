<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\GetCriticalVulnerabilities;
use App\Domain\Tenant\Scans\Data\IssueCountsData;
use App\Domain\Tenant\Scans\Data\RiskGradeData;
use App\Domain\Tenant\Scans\Data\ScanDashboardData;
use App\Domain\Tenant\Scans\Queries\GetScanDashboard;
use App\Models\Dealer\Cyrisma;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
use Mockery\MockInterface;

it('returns null when the store has no Cyrisma row', function (): void {
    $store = Store::query()->firstOrFail();

    expect(resolve(GetCriticalVulnerabilities::class)->handleForStore($store))->toBeNull();
});

it('returns null when the Cyrisma row exists but has an empty instance_id', function (): void {
    $store = Store::query()->firstOrFail();
    Cyrisma::query()->create([
        'store_id' => $store->id,
        'short_name' => 'short',
        'instance_id' => '',
    ]);

    expect(resolve(GetCriticalVulnerabilities::class)->handleForStore($store->refresh()))->toBeNull();
});

it('returns critical count and days-since for a store with an instance_id', function (): void {
    $store = configureCyrismaStore();

    mockScanDashboard(critical: 5, lastScanDate: CarbonImmutable::now()->subDays(9)->format('M j, Y'));

    $result = resolve(GetCriticalVulnerabilities::class)->handleForStore($store->refresh());

    expect($result)->not->toBeNull();
    expect($result->critical_count)->toBe(5);
    expect($result->days_since_last_scan)->toBe(9);
});

it('returns degraded zero-state when the Cyrisma API fails', function (): void {
    $store = configureCyrismaStore();

    $this->mock(GetScanDashboard::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andThrow(new RuntimeException('boom'));
    });

    $result = resolve(GetCriticalVulnerabilities::class)->handleForStore($store->refresh());

    expect($result)->not->toBeNull();
    expect($result->critical_count)->toBe(0);
    expect($result->days_since_last_scan)->toBeNull();
});

it('aggregates critical counts across stores and uses the most recent scan', function (): void {
    $storeA = configureCyrismaStore();

    $storeB = Store::query()->create(['name' => 'Other '.uniqid(), 'slug' => 'other-'.uniqid()]);
    Cyrisma::query()->create([
        'store_id' => $storeB->id,
        'short_name' => 'other',
        'instance_id' => 'inst-other',
    ]);

    $now = CarbonImmutable::now();
    $aDate = $now->subDays(20)->format('M j, Y');
    $bDate = $now->subDays(4)->format('M j, Y');

    $this->mock(GetScanDashboard::class, function (MockInterface $mock) use ($storeA, $storeB, $aDate, $bDate): void {
        $mock->shouldReceive('handle')
            ->with(Mockery::on(static fn (Store $store): bool => $store->id === $storeA->id))
            ->andReturn(scanDashboard(critical: 3, lastScanDate: $aDate));

        $mock->shouldReceive('handle')
            ->with(Mockery::on(static fn (Store $store): bool => $store->id === $storeB->id))
            ->andReturn(scanDashboard(critical: 7, lastScanDate: $bDate));
    });

    $result = resolve(GetCriticalVulnerabilities::class)->handleForStores(
        Store::query()->whereIn('id', [$storeA->id, $storeB->id])->get(),
        $now,
    );

    expect($result)->not->toBeNull();
    expect($result->critical_count)->toBe(10);
    expect($result->days_since_last_scan)->toBe(4);
});

it('returns null from handleForStores when none of the stores have an instance_id', function (): void {
    $store = Store::query()->firstOrFail();

    $result = resolve(GetCriticalVulnerabilities::class)->handleForStores(collect([$store]));

    expect($result)->toBeNull();
});

function configureCyrismaStore(): Store
{
    $store = Store::query()->firstOrFail();
    Cyrisma::query()->create([
        'store_id' => $store->id,
        'short_name' => 'short-'.uniqid(),
        'instance_id' => 'inst-'.uniqid(),
    ]);

    return $store;
}

function mockScanDashboard(int $critical, ?string $lastScanDate): void
{
    test()->mock(GetScanDashboard::class, function (MockInterface $mock) use ($critical, $lastScanDate): void {
        $mock->shouldReceive('handle')->andReturn(scanDashboard($critical, $lastScanDate));
    });
}

function scanDashboard(int $critical, ?string $lastScanDate): ScanDashboardData
{
    return new ScanDashboardData(
        isConfigured: true,
        hasShortName: true,
        hasScanData: true,
        hasExternalScans: false,
        hasInternalScans: true,
        overallRisk: new RiskGradeData(current: 'B', previous: 'B', trend: 'flat'),
        vulnerabilityRisk: new RiskGradeData(current: 'B', previous: 'B', trend: 'flat'),
        issueCounts: new IssueCountsData(total: $critical, critical: $critical, high: 0, medium: 0, low: 0, grade: 'B'),
        lastScanDate: $lastScanDate,
    );
}
