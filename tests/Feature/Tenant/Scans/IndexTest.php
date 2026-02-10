<?php

declare(strict_types=1);

use App\Http\Livewire\Tenant\Scans\Index;
use App\Models\Dealer\Cyrisma;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->store = Store::query()->first();
    app()->instance('currentStore', $this->store->id);
});

describe('loadScanData', function (): void {
    it('sets loaded to true after loading', function (): void {
        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertSet('loaded', true);
    });

    it('shows error when store cannot be found', function (): void {
        app()->instance('currentStore', 99999);

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertSet('loaded', true)
            ->assertSet('error', 'Unable to load store information. Please try again later.');
    });

    it('detects when cyrisma is not configured', function (): void {
        config(['services.cyrisma.base_url' => null]);
        config(['services.cyrisma.api_key' => null]);
        config(['services.cyrisma.api_secret' => null]);

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertSet('loaded', true)
            ->assertSet('isConfigured', false)
            ->assertSet('error', null);
    });

    it('detects when store has no short name configured', function (): void {
        config([
            'services.cyrisma.base_url' => 'https://cyrisma.test',
            'services.cyrisma.api_key' => 'test-key',
            'services.cyrisma.api_secret' => 'test-secret',
        ]);

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertSet('loaded', true)
            ->assertSet('isConfigured', true)
            ->assertSet('hasShortName', false)
            ->assertSet('error', null);
    });

    it('catches exceptions from the cyrisma service and sets error', function (): void {
        $mock = $this->mock(CyrismaService::class);
        $mock->shouldReceive('forStore')->andThrow(new RuntimeException('Connection refused'));

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertSet('loaded', true)
            ->assertSet('error', 'Unable to connect to the scanning service. Please try again later.');
    });

    it('resets error state at the start of each load', function (): void {
        app()->instance('currentStore', 99999);

        $component = Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertSet('error', 'Unable to load store information. Please try again later.');

        app()->instance('currentStore', $this->store->id);

        $component->call('loadScanData')
            ->assertSet('error', null);
    });
});

describe('refreshCache', function (): void {
    it('dispatches refresh-page browser event', function (): void {
        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('refreshCache')
            ->assertDispatchedBrowserEvent('refresh-page');
    });

    it('handles missing store gracefully', function (): void {
        app()->instance('currentStore', 99999);

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('refreshCache')
            ->assertDispatchedBrowserEvent('refresh-page');
    });

    it('handles service exceptions gracefully', function (): void {
        $mock = $this->mock(CyrismaService::class);
        $mock->shouldReceive('forStore')->andThrow(new RuntimeException('Connection refused'));

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('refreshCache')
            ->assertDispatchedBrowserEvent('refresh-page');
    });
});

describe('view rendering', function (): void {
    it('shows loading skeleton when not loaded', function (): void {
        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->assertSet('loaded', false)
            ->assertSee('animate-pulse');
    });

    it('shows error state with retry button when error occurs', function (): void {
        app()->instance('currentStore', 99999);

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertSee('Connection Error')
            ->assertSee('Try Again');
    });

    it('shows not configured warning when api credentials are missing', function (): void {
        config(['services.cyrisma.base_url' => null]);
        config(['services.cyrisma.api_key' => null]);
        config(['services.cyrisma.api_secret' => null]);

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertSee('API Not Configured');
    });

    it('shows short name warning when instance is not linked', function (): void {
        config([
            'services.cyrisma.base_url' => 'https://cyrisma.test',
            'services.cyrisma.api_key' => 'test-key',
            'services.cyrisma.api_secret' => 'test-secret',
        ]);

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertSee('Instance Not Configured');
    });

    it('shows no scan results message when configured but no scans exist', function (): void {
        Cyrisma::query()->create([
            'store_id' => $this->store->id,
            'short_name' => 'test-instance',
            'instance_id' => 'inst-123',
            'instance_url' => 'test.cyrisma.com',
        ]);

        $mock = $this->mock(CyrismaService::class);
        $mock->shouldReceive('forStore')->andReturn($mock);
        $mock->shouldReceive('isConfigured')->andReturn(true);
        $mock->shouldReceive('hasShortName')->andReturn(true);
        $mock->shouldReceive('getExternalIpScanData')->andReturn(null);
        $mock->shouldReceive('hasInternalScans')->andReturn(false);
        $mock->shouldReceive('getOverallDashboard')->andReturn([]);
        $mock->shouldReceive('getVulnerabilityScans')->andReturn(null);

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertSet('hasExternalScans', false)
            ->assertSet('hasInternalScans', false)
            ->assertSee('No Scan Results Available');
    });
});
