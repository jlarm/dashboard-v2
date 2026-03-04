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

describe('route access', function (): void {
    it('redirects to dashboard when current_store_id is null', function (): void {
        tenant()->update(['locations' => true]);

        Store::query()->create([
            'name' => 'Second Route Store',
            'slug' => 'second-route-store',
        ]);

        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.index'))
            ->assertRedirect(route('dealer.dashboard'));
    });

    it('allows scans when current_store_id is set', function (): void {
        tenant()->update(['locations' => true]);

        $this->consultant->update(['current_store_id' => $this->store->id]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.index'))
            ->assertOk();
    });
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
        app()->instance('scopedStoreIds', collect([99999]));

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
        app()->instance('scopedStoreIds', collect([99999]));

        $component = Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertSet('error', 'Unable to load store information. Please try again later.');

        app()->instance('currentStore', $this->store->id);

        $component->set('storeId', $this->store->id)
            ->call('loadScanData')
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
    it('shows overview cards when no single store is selected and multiple stores are in scope', function (): void {
        $storeB = Store::query()->create([
            'name' => 'Overview Scan Store B',
            'slug' => 'overview-scan-store-b',
        ]);

        app()->instance('currentStore', null);
        app()->instance('scopedStoreIds', collect([$this->store->id, $storeB->id]));

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->assertSet('showOverview', true)
            ->assertSee('IT Scans Overview')
            ->assertSee($this->store->name)
            ->assertSee($storeB->name);
    });

    it('shows loading skeleton when not loaded', function (): void {
        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->assertSet('loaded', false)
            ->assertSee('animate-pulse');
    });

    it('shows error state with retry button when error occurs', function (): void {
        app()->instance('currentStore', 99999);
        app()->instance('scopedStoreIds', collect([99999]));

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
            ->assertSee('Contact your consultant');
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

    it('does not dispatch scan-loaded event before loadScanData is called', function (): void {
        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->assertSet('loaded', false)
            ->assertNotDispatchedBrowserEvent('scan-loaded');
    });

    it('dispatches scan-loaded with showDownloads false when not configured', function (): void {
        $mock = $this->mock(CyrismaService::class);
        $mock->shouldReceive('forStore')->andReturn($mock);
        $mock->shouldReceive('isConfigured')->andReturn(false);
        $mock->shouldReceive('hasShortName')->andReturn(false);

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertDispatchedBrowserEvent('scan-loaded', ['showDownloads' => false]);
    });

    it('dispatches scan-loaded with showDownloads true when configured with a short name', function (): void {
        $mock = $this->mock(CyrismaService::class);
        $mock->shouldReceive('forStore')->andReturn($mock);
        $mock->shouldReceive('isConfigured')->andReturn(true);
        $mock->shouldReceive('hasShortName')->andReturn(true);
        $mock->shouldReceive('getVulnerabilityScans')->andReturn(['vulnerability_scans' => []]);
        $mock->shouldReceive('getExternalIpScanData')->andReturn(['assets' => []]);
        $mock->shouldReceive('hasInternalScans')->andReturn(false);
        $mock->shouldReceive('getOverallDashboard')->andReturn([]);

        Livewire::actingAs($this->consultant)
            ->test(Index::class)
            ->call('loadScanData')
            ->assertDispatchedBrowserEvent('scan-loaded', ['showDownloads' => true]);
    });
});
