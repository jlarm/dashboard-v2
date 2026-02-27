<?php

declare(strict_types=1);

use App\Http\Livewire\Tenant\Scans\Components\ExternalIpExposure;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->store = Store::query()->first();
    app()->instance('currentStore', $this->store->id);
});

function mockExternalAssets(array $assets): void
{
    $mock = test()->mock(CyrismaService::class);
    $mock->shouldReceive('getExternalIpScanData')->andReturn([
        'scan_info' => ['scan_finished' => '2026-02-27 09:29:42'],
        'assets' => $assets,
    ]);
}

it('renders web application flaws and sorts findings by severity', function (): void {
    mockExternalAssets([
        [
            'name' => 'https://www.plazaford.com/',
            'ipAddress' => 'https://www.plazaford.com/',
            'flaws' => [
                ['alertName' => 'User Agent Fuzzer', 'riskLevel' => 'Info', 'alertCount' => 31],
                ['alertName' => 'Cross-Domain JavaScript Source File Inclusion', 'riskLevel' => 'Low', 'alertCount' => 5],
                ['alertName' => 'Hidden File Found', 'riskLevel' => 'Medium', 'alertCount' => 4],
            ],
        ],
    ]);

    Livewire::actingAs($this->consultant)
        ->test(ExternalIpExposure::class)
        ->assertSee('Vulnerability Findings')
        ->assertSee('Flaw')
        ->assertSee('Risk Level')
        ->assertSee('Affected URLs')
        ->assertSee('Hidden File Found')
        ->assertSee('Cross-Domain JavaScript Source File Inclusion')
        ->assertSee('User Agent Fuzzer')
        ->assertSeeInOrder([
            'Hidden File Found',
            'Cross-Domain JavaScript Source File Inclusion',
            'User Agent Fuzzer',
        ]);
});

it('continues to render vulnerability findings when vulnerabilities are provided', function (): void {
    mockExternalAssets([
        [
            'name' => '203.0.113.10',
            'ipAddress' => '203.0.113.10',
            'vulnerabilities' => [
                ['title' => 'Outdated SSH Version', 'riskLevel' => 'High', 'affectedUrls' => 0],
            ],
        ],
    ]);

    Livewire::actingAs($this->consultant)
        ->test(ExternalIpExposure::class)
        ->assertSee('Outdated SSH Version')
        ->assertSee('High');
});

it('opens a modal with flaw details when a finding is clicked', function (): void {
    mockExternalAssets([
        [
            'name' => 'https://www.plazaford.com/',
            'ipAddress' => 'https://www.plazaford.com/',
            'flaws' => [
                [
                    'alertName' => 'Hidden File Found',
                    'riskLevel' => 'Medium',
                    'alertCount' => 4,
                    'alertDesc' => '<p>A sensitive file was identified as accessible or available.</p>',
                    'alertSolution' => '<p>Disable access to the sensitive file in production.</p>',
                    'references' => ['<p>https://blog.hboeck.de/archives/892-Introducing-Snuffleupagus.html</p>'],
                    'instances' => [
                        [
                            'uri' => 'https://plazaford.com/.darcs',
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

    Livewire::actingAs($this->consultant)
        ->test(ExternalIpExposure::class)
        ->call('openFindingModal', 0, 0)
        ->assertSet('isFindingModalOpen', true)
        ->assertSee('Hidden File Found')
        ->assertSee('Risk Level: Medium')
        ->assertSee('Description')
        ->assertSee('A sensitive file was identified as accessible or available.')
        ->assertDontSee('&lt;p&gt;A sensitive file was identified as accessible or available.&lt;/p&gt;')
        ->assertSee('Solution')
        ->assertSee('Disable access to the sensitive file in production.')
        ->assertDontSee('&lt;p&gt;Disable access to the sensitive file in production.&lt;/p&gt;')
        ->assertSee('Reference Links')
        ->assertSee('https://blog.hboeck.de/archives/892-Introducing-Snuffleupagus.html')
        ->assertDontSee('&lt;p&gt;https://blog.hboeck.de/archives/892-Introducing-Snuffleupagus.html&lt;/p&gt;')
        ->assertSee('https://plazaford.com/.darcs')
        ->call('closeFindingModal')
        ->assertSet('isFindingModalOpen', false);
});

it('does not render description or solution sections when they are missing', function (): void {
    mockExternalAssets([
        [
            'name' => 'https://www.plazaford.com/',
            'ipAddress' => 'https://www.plazaford.com/',
            'flaws' => [
                [
                    'alertName' => 'User Agent Fuzzer',
                    'riskLevel' => 'Info',
                    'alertCount' => 1,
                    'instances' => [
                        [
                            'uri' => 'https://plazaford.com/',
                            'method' => 'GET',
                        ],
                    ],
                ],
            ],
        ],
    ]);

    Livewire::actingAs($this->consultant)
        ->test(ExternalIpExposure::class)
        ->call('openFindingModal', 0, 0)
        ->assertSet('isFindingModalOpen', true)
        ->assertDontSee('Description')
        ->assertDontSee('Solution');
});

it('loads missing flaw details from web findings endpoint when opening the modal', function (): void {
    $asset = [
        'name' => 'https://www.plazaford.com/',
        'ipAddress' => 'https://www.plazaford.com/',
        'assetId' => 'web-asset-123',
        'flaws' => [
            [
                'alertName' => 'Hidden File Found',
                'riskLevel' => 'Medium',
                'alertCount' => 4,
            ],
        ],
    ];

    $mock = test()->mock(CyrismaService::class);
    $mock->shouldReceive('getExternalIpScanData')->andReturn([
        'scan_info' => ['scan_finished' => '2026-02-27 09:29:42'],
        'assets' => [$asset],
    ]);
    $mock->shouldReceive('forStore')->once()->with(Mockery::type(Store::class))->andReturn($mock);
    $mock->shouldReceive('getWebApplicationScanFindingsForAsset')
        ->once()
        ->withArgs(fn (array $payload, string $finding): bool => ($payload['assetId'] ?? null) === 'web-asset-123' && $finding === 'Hidden File Found')
        ->andReturn([
            [
                'name' => 'Hidden File Found',
                'severity' => 'Medium',
                'description' => '<p>A sensitive file was identified as accessible or available.</p>',
                'solution' => '<p>Disable access to this component in production.</p>',
                'referenceURLs' => ['<p>https://blog.hboeck.de/archives/892-Introducing-Snuffleupagus.html</p>'],
                'findingsCount' => 1,
                'details' => [
                    [
                        'URL' => 'https://plazaford.com/.darcs',
                        'Method' => 'GET',
                        'Parameters' => '-',
                        'Attack' => '-',
                        'Evidence' => '-',
                    ],
                ],
            ],
        ]);

    Livewire::actingAs($this->consultant)
        ->test(ExternalIpExposure::class)
        ->call('openFindingModal', 0, 0)
        ->assertSet('isFindingModalOpen', true)
        ->assertSee('Description')
        ->assertSee('A sensitive file was identified as accessible or available.')
        ->assertDontSee('&lt;p&gt;A sensitive file was identified as accessible or available.&lt;/p&gt;')
        ->assertSee('Solution')
        ->assertSee('Disable access to this component in production.')
        ->assertDontSee('&lt;p&gt;Disable access to this component in production.&lt;/p&gt;')
        ->assertSee('https://blog.hboeck.de/archives/892-Introducing-Snuffleupagus.html')
        ->assertDontSee('&lt;p&gt;https://blog.hboeck.de/archives/892-Introducing-Snuffleupagus.html&lt;/p&gt;')
        ->assertSee('https://plazaford.com/.darcs')
        ->assertSee('GET');
});

it('renders instance rows when web finding provides details in other payload', function (): void {
    $asset = [
        'name' => 'https://www.plazaford.com/',
        'ipAddress' => 'https://www.plazaford.com/',
        'assetId' => 'web-asset-123',
        'flaws' => [
            [
                'alertName' => 'Cross-Domain JavaScript Source File Inclusion',
                'riskLevel' => 'Low',
                'alertCount' => 5,
            ],
        ],
    ];

    $mock = test()->mock(CyrismaService::class);
    $mock->shouldReceive('getExternalIpScanData')->andReturn([
        'scan_info' => ['scan_finished' => '2026-02-27 09:29:42'],
        'assets' => [$asset],
    ]);
    $mock->shouldReceive('forStore')->once()->with(Mockery::type(Store::class))->andReturn($mock);
    $mock->shouldReceive('getWebApplicationScanFindingsForAsset')
        ->once()
        ->withArgs(fn (array $payload, string $finding): bool => ($payload['assetId'] ?? null) === 'web-asset-123' && $finding === 'Cross-Domain JavaScript Source File Inclusion')
        ->andReturn([
            [
                'name' => 'Cross-Domain JavaScript Source File Inclusion',
                'severity' => 'Low',
                'description' => 'The page includes one or more script files from a third-party domain.',
                'solution' => 'Ensure JavaScript source files are loaded from trusted sources.',
                'findingsCount' => 2,
                'other' => [
                    'https://barnsaa.dealeron.com/banner.js',
                    'https://media.assets.dealeron.com/agency/release/harmoniq/init.umd.js',
                ],
            ],
        ]);

    Livewire::actingAs($this->consultant)
        ->test(ExternalIpExposure::class)
        ->call('openFindingModal', 0, 0)
        ->assertSet('isFindingModalOpen', true)
        ->assertSee('Cross-Domain JavaScript Source File Inclusion')
        ->assertSee('https://barnsaa.dealeron.com/banner.js')
        ->assertSee('https://media.assets.dealeron.com/agency/release/harmoniq/init.umd.js');
});
