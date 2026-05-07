<?php

declare(strict_types=1);

use App\Domain\Tenant\Scans\Queries\GetExternalFindingDetails;
use App\Domain\Tenant\Scans\Queries\GetExternalIpExposure;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;

beforeEach(function (): void {
    $this->store = Store::query()->first();
});

function mockExternalAssets(array $assets, ?string $scanFinished = '2026-02-27 09:29:42'): void
{
    $mock = test()->mock(CyrismaService::class);
    $mock->shouldReceive('forStore')->andReturn($mock);
    $mock->shouldReceive('getExternalIpScanData')->andReturn([
        'scan_info' => $scanFinished !== null ? ['scan_finished' => $scanFinished] : [],
        'assets' => $assets,
    ]);
}

it('returns null lastScanFinished and no assets when the service returns null', function (): void {
    $mock = $this->mock(CyrismaService::class);
    $mock->shouldReceive('forStore')->andReturn($mock);
    $mock->shouldReceive('getExternalIpScanData')->andReturn(null);

    $result = resolve(GetExternalIpExposure::class)->handle($this->store);

    expect($result->toArray())->toMatchArray([
        'last_scan_finished' => null,
        'assets' => [],
    ]);
});

it('exposes the last scan finished timestamp and the asset list', function (): void {
    mockExternalAssets([
        [
            'name' => '203.0.113.10',
            'ipAddress' => '203.0.113.10',
            'vulnerabilities' => [
                ['title' => 'Outdated SSH Version', 'riskLevel' => 'High', 'affectedUrls' => 0],
            ],
        ],
    ]);

    $result = resolve(GetExternalIpExposure::class)->handle($this->store)->toArray();

    expect($result['last_scan_finished'])->toBe('2026-02-27 09:29:42');
    expect($result['assets'])->toHaveCount(1);
    expect($result['assets'][0]['ip_address'])->toBe('203.0.113.10');
    expect($result['assets'][0]['findings'][0]['name'])->toBe('Outdated SSH Version');
});

it('sorts findings by severity then affected url count', function (): void {
    mockExternalAssets([
        [
            'name' => 'https://www.example.com/',
            'ipAddress' => 'https://www.example.com/',
            'flaws' => [
                ['alertName' => 'User Agent Fuzzer', 'riskLevel' => 'Info', 'alertCount' => 31],
                ['alertName' => 'Cross-Domain JavaScript Source File Inclusion', 'riskLevel' => 'Low', 'alertCount' => 5],
                ['alertName' => 'Hidden File Found', 'riskLevel' => 'Medium', 'alertCount' => 4],
            ],
        ],
    ]);

    $assets = resolve(GetExternalIpExposure::class)->handle($this->store)->toArray()['assets'];

    expect($assets[0]['findings'])->toHaveCount(3);
    expect(array_column($assets[0]['findings'], 'name'))->toBe([
        'Hidden File Found',
        'Cross-Domain JavaScript Source File Inclusion',
        'User Agent Fuzzer',
    ]);
});

it('strips HTML and decodes entities in description, solution, and references', function (): void {
    mockExternalAssets([
        [
            'name' => 'https://www.example.com/',
            'ipAddress' => 'https://www.example.com/',
            'flaws' => [
                [
                    'alertName' => 'Hidden File Found',
                    'riskLevel' => 'Medium',
                    'alertCount' => 4,
                    'alertDesc' => '<p>A sensitive file was identified as accessible or available.</p>',
                    'alertSolution' => '<p>Disable access to the sensitive file in production.</p>',
                    'references' => ['<p>https://blog.example.com/article</p>'],
                    'instances' => [
                        [
                            'uri' => 'https://example.com/.darcs',
                            'method' => 'GET',
                            'param' => '-',
                            'attack' => '-',
                            'evidence' => 'directory listing',
                        ],
                    ],
                ],
            ],
        ],
    ]);

    $finding = resolve(GetExternalIpExposure::class)->handle($this->store)->toArray()['assets'][0]['findings'][0];

    expect($finding['description'])->toBe('A sensitive file was identified as accessible or available.');
    expect($finding['solution'])->toBe('Disable access to the sensitive file in production.');
    expect($finding['references'])->toBe(['https://blog.example.com/article']);
    expect($finding['instances'])->toHaveCount(1);
    expect($finding['instances'][0]['url'])->toBe('https://example.com/.darcs');
    expect($finding['instances'][0]['evidence'])->toBe('directory listing');
});

it('leaves description and solution empty when the upstream payload omits them', function (): void {
    mockExternalAssets([
        [
            'name' => 'https://www.example.com/',
            'ipAddress' => 'https://www.example.com/',
            'flaws' => [
                [
                    'alertName' => 'User Agent Fuzzer',
                    'riskLevel' => 'Info',
                    'alertCount' => 1,
                    'instances' => [
                        ['uri' => 'https://example.com/', 'method' => 'GET'],
                    ],
                ],
            ],
        ],
    ]);

    $finding = resolve(GetExternalIpExposure::class)->handle($this->store)->toArray()['assets'][0]['findings'][0];

    expect($finding['description'])->toBe('');
    expect($finding['solution'])->toBe('');
});

it('produces a clean tone when an asset has no findings or open ports', function (): void {
    mockExternalAssets([
        ['name' => 'clean.example.com', 'ipAddress' => '203.0.113.99', 'flaws' => [], 'vulnerabilities' => []],
    ]);

    $asset = resolve(GetExternalIpExposure::class)->handle($this->store)->toArray()['assets'][0];

    expect($asset['tone'])->toBe('clean');
    expect($asset['counts']['total'])->toBe(0);
});

describe('GetExternalFindingDetails', function (): void {
    it('lazily loads finding details from the web-app findings endpoint and normalizes them', function (): void {
        $mock = test()->mock(CyrismaService::class);
        $mock->shouldReceive('forStore')->andReturn($mock);
        $mock->shouldReceive('getExternalIpScanData')->andReturn([
            'scan_info' => [],
            'assets' => [
                [
                    'name' => 'https://www.example.com/',
                    'ipAddress' => '203.0.113.10',
                    'assetId' => 'web-asset-123',
                    'flaws' => [['alertName' => 'Hidden File Found', 'riskLevel' => 'Medium', 'alertCount' => 4]],
                ],
            ],
        ]);
        $mock->shouldReceive('getWebApplicationScanFindingsForAsset')
            ->once()
            ->withArgs(fn (array $payload, string $finding): bool => ($payload['assetId'] ?? null) === 'web-asset-123' && $finding === 'Hidden File Found')
            ->andReturn([
                [
                    'name' => 'Hidden File Found',
                    'severity' => 'Medium',
                    'description' => '<p>A sensitive file was identified as accessible.</p>',
                    'solution' => '<p>Disable access in production.</p>',
                    'referenceURLs' => ['<p>https://blog.example.com/article</p>'],
                    'findingsCount' => 1,
                    'details' => [
                        ['URL' => 'https://example.com/.darcs', 'Method' => 'GET', 'Parameters' => '-', 'Attack' => '-', 'Evidence' => '-'],
                    ],
                ],
            ]);

        $result = resolve(GetExternalFindingDetails::class)->handle($this->store, '203.0.113.10', 'Hidden File Found');

        expect($result)->not->toBeNull();
        expect($result->description)->toBe('A sensitive file was identified as accessible.');
        expect($result->solution)->toBe('Disable access in production.');
        expect($result->references)->toBe(['https://blog.example.com/article']);
        expect($result->instances)->toHaveCount(1);
        expect($result->instances[0]['url'])->toBe('https://example.com/.darcs');
    });

    it('handles instance rows from a non-standard "other" payload key', function (): void {
        $mock = test()->mock(CyrismaService::class);
        $mock->shouldReceive('forStore')->andReturn($mock);
        $mock->shouldReceive('getExternalIpScanData')->andReturn([
            'scan_info' => [],
            'assets' => [
                [
                    'name' => 'https://www.example.com/',
                    'ipAddress' => '203.0.113.10',
                    'assetId' => 'web-asset-123',
                    'flaws' => [['alertName' => 'Cross-Domain JavaScript Source File Inclusion', 'riskLevel' => 'Low', 'alertCount' => 5]],
                ],
            ],
        ]);
        $mock->shouldReceive('getWebApplicationScanFindingsForAsset')
            ->once()
            ->andReturn([
                [
                    'name' => 'Cross-Domain JavaScript Source File Inclusion',
                    'severity' => 'Low',
                    'description' => 'The page includes a third-party script.',
                    'solution' => 'Load scripts from trusted sources.',
                    'findingsCount' => 2,
                    'other' => [
                        'https://cdn.example.com/banner.js',
                        'https://cdn.example.com/init.js',
                    ],
                ],
            ]);

        $result = resolve(GetExternalFindingDetails::class)->handle($this->store, '203.0.113.10', 'Cross-Domain JavaScript Source File Inclusion');

        expect($result)->not->toBeNull();
        expect(array_column($result->instances, 'parameters'))->toContain(
            'https://cdn.example.com/banner.js',
            'https://cdn.example.com/init.js',
        );
    });

    it('returns null when the asset cannot be located by IP', function (): void {
        $mock = test()->mock(CyrismaService::class);
        $mock->shouldReceive('forStore')->andReturn($mock);
        $mock->shouldReceive('getExternalIpScanData')->andReturn([
            'scan_info' => [],
            'assets' => [['name' => 'other', 'ipAddress' => '198.51.100.1', 'flaws' => []]],
        ]);

        $result = resolve(GetExternalFindingDetails::class)->handle($this->store, '203.0.113.10', 'anything');

        expect($result)->toBeNull();
    });
});
