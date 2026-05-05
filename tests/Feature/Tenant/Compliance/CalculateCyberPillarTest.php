<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\CalculateCyberPillar;
use App\Domain\Tenant\Scans\Data\IssueCountsData;
use App\Domain\Tenant\Scans\Data\RiskGradeData;
use App\Domain\Tenant\Scans\Data\ScanDashboardData;
use App\Domain\Tenant\Scans\Queries\GetScanDashboard;
use App\Models\Dealer\Cyrisma;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
use Mockery\MockInterface;
use RuntimeException;

it('marks the pillar as not applicable when the store has no Cyrisma short_name', function (): void {
    $store = Store::query()->firstOrFail();

    $pillar = resolve(CalculateCyberPillar::class)->handle($store, CarbonImmutable::now());

    expect($pillar->applicable)->toBeFalse();
    expect($pillar->notApplicableReason)->toBe('This store does not use IT scans.');
});

it('scores 100 with no issues and a recent scan', function (): void {
    $store = cyberFixtureStore();
    $now = CarbonImmutable::create(2026, 5, 1);

    mockScanDashboard(
        hasScanData: true,
        issueCounts: new IssueCountsData(0, 0, 0, 0, 0, 'A'),
        lastScanDate: 'Apr 25, 2026',
    );

    $pillar = resolve(CalculateCyberPillar::class)->handle($store, $now);

    expect($pillar->applicable)->toBeTrue();
    expect($pillar->score)->toBe(100.0);
});

it('penalizes critical and high CVEs with the configured weights', function (): void {
    $store = cyberFixtureStore();
    $now = CarbonImmutable::create(2026, 5, 1);

    mockScanDashboard(
        hasScanData: true,
        issueCounts: new IssueCountsData(10, 2, 1, 5, 2, 'C'),
        lastScanDate: 'Apr 25, 2026',
    );

    $pillar = resolve(CalculateCyberPillar::class)->handle($store, $now);

    // 2 critical * 8 + 1 high * 3 + 5 medium * 1 = 24
    expect($pillar->score)->toBe(76.0);
    expect($pillar->breakdown['issue_penalty'])->toBe(24.0);
});

it('caps the issue penalty at 60 points', function (): void {
    $store = cyberFixtureStore();
    $now = CarbonImmutable::create(2026, 5, 1);

    mockScanDashboard(
        hasScanData: true,
        issueCounts: new IssueCountsData(100, 50, 0, 0, 0, 'F'),
        lastScanDate: 'Apr 25, 2026',
    );

    $pillar = resolve(CalculateCyberPillar::class)->handle($store, $now);

    expect($pillar->breakdown['issue_penalty'])->toBe(60.0);
    expect($pillar->score)->toBe(40.0);
});

it('penalizes staleness when the last scan is older than 30 days', function (): void {
    $store = cyberFixtureStore();
    $now = CarbonImmutable::create(2026, 5, 1);

    mockScanDashboard(
        hasScanData: true,
        issueCounts: new IssueCountsData(0, 0, 0, 0, 0, 'A'),
        lastScanDate: 'Mar 1, 2026', // 61 days before now → 31 days over threshold → ~31 pts (capped at 30)
    );

    $pillar = resolve(CalculateCyberPillar::class)->handle($store, $now);

    expect($pillar->breakdown['days_since_last_scan'])->toBe(61);
    expect($pillar->breakdown['staleness_penalty'])->toBe(30.0);
    expect($pillar->score)->toBe(70.0);
});

it('returns a low baseline when Cyrisma is configured but has no scan data', function (): void {
    $store = cyberFixtureStore();

    mockScanDashboard(
        hasScanData: false,
        issueCounts: IssueCountsData::empty(),
        lastScanDate: null,
    );

    $pillar = resolve(CalculateCyberPillar::class)->handle($store, CarbonImmutable::now());

    expect($pillar->applicable)->toBeTrue();
    expect($pillar->score)->toBe(40.0);
    expect($pillar->breakdown['note'])->toBe('No scan results yet.');
});

it('falls back to a degraded score when the Cyrisma API throws', function (): void {
    $store = cyberFixtureStore();

    $this->mock(GetScanDashboard::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andThrow(new RuntimeException('API down'));
    });

    $pillar = resolve(CalculateCyberPillar::class)->handle($store, CarbonImmutable::now());

    expect($pillar->applicable)->toBeTrue();
    expect($pillar->score)->toBe(50.0);
    expect($pillar->breakdown['state'])->toBe('degraded');
});

function cyberFixtureStore(): Store
{
    $store = Store::query()->firstOrFail();

    Cyrisma::query()->updateOrCreate(
        ['store_id' => $store->id],
        ['short_name' => 'TEST', 'instance_id' => '123', 'instance_url' => 'https://example.com'],
    );

    return $store->fresh()->load('cyrisma');
}

function mockScanDashboard(
    bool $hasScanData,
    IssueCountsData $issueCounts,
    ?string $lastScanDate,
): void {
    $dashboard = new ScanDashboardData(
        isConfigured: true,
        hasShortName: true,
        hasScanData: $hasScanData,
        hasExternalScans: false,
        hasInternalScans: false,
        overallRisk: RiskGradeData::fromOverallDashboard([], 'or'),
        vulnerabilityRisk: RiskGradeData::fromOverallDashboard([], 'vn'),
        issueCounts: $issueCounts,
        lastScanDate: $lastScanDate,
    );

    test()->mock(GetScanDashboard::class, function (MockInterface $mock) use ($dashboard): void {
        $mock->shouldReceive('handle')->andReturn($dashboard);
    });
}
