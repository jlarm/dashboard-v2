<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Services\CyrismaService;

beforeEach(function (): void {
    $this->store = Store::query()->first();
});

/**
 * @param  array<string, mixed>  $latestScan
 * @param  array<int, array<string, mixed>>  $assets
 */
function fakeCyrismaWithScan(array $latestScan, array $assets): CyrismaService
{
    return test()->partialMock(CyrismaService::class, function ($mock) use ($latestScan, $assets): void {
        $mock->shouldReceive('getStoreReport')
            ->with('scans/vulnerability')
            ->andReturn(['vulnerability_scans' => [$latestScan]]);
        $mock->shouldReceive('getStoreReport')
            ->with('scans/vulnerability/'.$latestScan['scan_id'])
            ->andReturn(['assets' => $assets]);
    });
}

it('includes internal unauthenticated scans (scan type 10) when filtering by internal asset type', function (): void {
    $service = fakeCyrismaWithScan(
        ['scan_id' => 77, 'scan_type' => 10, 'scan_type_name' => 'Internal Unauthenticated', 'scan_finished' => '2026-05-01'],
        [[
            'name' => 'WORKSTATION-01',
            'vulnerabilities' => [
                ['cve' => 'CVE-2026-1234', 'title' => 'Sample vuln', 'score' => 9.8, 'riskLevel' => 'Critical', 'firstSeen' => '2026-04-01'],
            ],
        ]],
    );

    $result = $service->forStore($this->store)->getVulnerabilitiesByAssetType('internal');

    expect($result['vulnerabilities'])->toHaveCount(1)
        ->and($result['vulnerabilities'][0]['id'])->toBe('CVE-2026-1234');
});

it('still includes internal authenticated scans (scan type 5) when filtering by internal asset type', function (): void {
    $service = fakeCyrismaWithScan(
        ['scan_id' => 88, 'scan_type' => 5, 'scan_type_name' => 'Internal Authenticated', 'scan_finished' => '2026-05-01'],
        [[
            'name' => 'SERVER-01',
            'vulnerabilities' => [
                ['cve' => 'CVE-2026-5678', 'title' => 'Another vuln', 'score' => 7.5, 'riskLevel' => 'High', 'firstSeen' => '2026-04-10'],
            ],
        ]],
    );

    $result = $service->forStore($this->store)->getVulnerabilitiesByAssetType('internal');

    expect($result['vulnerabilities'])->toHaveCount(1)
        ->and($result['vulnerabilities'][0]['id'])->toBe('CVE-2026-5678');
});

it('excludes external scans when filtering by internal asset type', function (): void {
    $service = fakeCyrismaWithScan(
        ['scan_id' => 99, 'scan_type' => 9, 'scan_type_name' => 'External IP', 'scan_finished' => '2026-05-01'],
        [['name' => 'EDGE-01', 'vulnerabilities' => []]],
    );

    $result = $service->forStore($this->store)->getVulnerabilitiesByAssetType('internal');

    expect($result['vulnerabilities'])->toBe([]);
});
