<?php

declare(strict_types=1);

use App\Domain\Tenant\Scans\Queries\GetScanDashboard;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;

beforeEach(function (): void {
    $this->store = Store::query()->first();
});

/**
 * @param  array<int, array<string, mixed>>  $scans
 * @param  array<string, mixed>  $overallDashboard
 */
function mockScanDashboardService(array $scans, array $overallDashboard = []): CyrismaService
{
    $service = test()->mock(CyrismaService::class);
    $service->shouldReceive('forStore')->andReturn($service);
    $service->shouldReceive('isConfigured')->andReturn(true);
    $service->shouldReceive('hasShortName')->andReturn(true);
    $service->shouldReceive('getVulnerabilityScans')->andReturn(['vulnerability_scans' => $scans]);
    $service->shouldReceive('getOverallDashboard')->andReturn($overallDashboard);
    $service->shouldReceive('getExternalIpScanData')->andReturn(null);
    $service->shouldReceive('hasInternalScans')->andReturn(true);

    return $service;
}

it('falls back to the latest scan letter grade when the overall dashboard has no grades', function (): void {
    mockScanDashboardService([
        ['scan_finished' => '2026-05-11 09:16:07', 'grade_alpha' => 'B+', 'vulnerabilities' => 20],
        ['scan_finished' => '2026-05-18 09:18:24', 'grade_alpha' => 'B', 'vulnerabilities' => 27],
    ]);

    $dashboard = resolve(GetScanDashboard::class)->handle($this->store)->toArray();

    expect($dashboard['vulnerability_risk'])->toMatchArray([
        'current' => 'B',
        'previous' => 'B+',
        'trend' => 'declined',
    ]);
    expect($dashboard['overall_risk'])->toMatchArray([
        'current' => 'B',
        'previous' => 'B+',
    ]);
});

it('prefers the overall dashboard grade over the scan grade when present', function (): void {
    mockScanDashboardService(
        [['scan_finished' => '2026-05-18 09:18:24', 'grade_alpha' => 'B']],
        ['current_or_grade' => 'A-', 'previous_or_grade' => 'B+'],
    );

    $dashboard = resolve(GetScanDashboard::class)->handle($this->store)->toArray();

    expect($dashboard['overall_risk'])->toMatchArray([
        'current' => 'A-',
        'previous' => 'B+',
        'trend' => 'improved',
    ]);
    // vulnerability has no dashboard grade, so it still falls back to the scan
    expect($dashboard['vulnerability_risk']['current'])->toBe('B');
});

it('leaves grades empty when there are no scans', function (): void {
    mockScanDashboardService([]);

    $dashboard = resolve(GetScanDashboard::class)->handle($this->store)->toArray();

    expect($dashboard['overall_risk']['current'])->toBeNull();
    expect($dashboard['vulnerability_risk']['current'])->toBeNull();
});
