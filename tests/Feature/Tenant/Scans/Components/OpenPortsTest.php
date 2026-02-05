<?php

declare(strict_types=1);

use App\Http\Livewire\Tenant\Scans\Components\OpenPorts;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Livewire\Livewire;

beforeEach(function () {
    $this->store = Store::first();
    app()->instance('currentStore', $this->store->id);
});

function mockCyrismaOpenPorts(int $count = 4, string $expectedAssetType = ''): void
{
    $ports = [];
    $portData = [
        ['portNumber' => '135', 'portDescription' => 'DCE endpoint resolution', 'riskLevel' => 'Low', 'machineCount' => 2],
        ['portNumber' => '139', 'portDescription' => 'NETBIOS Session Service', 'riskLevel' => 'Medium', 'machineCount' => 1],
        ['portNumber' => '445', 'portDescription' => 'Microsoft-DS', 'riskLevel' => 'Medium', 'machineCount' => 1],
        ['portNumber' => '5357', 'portDescription' => 'Web Services for Devices', 'riskLevel' => 'Low', 'machineCount' => 2],
        ['portNumber' => '80', 'portDescription' => 'HTTP', 'riskLevel' => 'High', 'machineCount' => 3],
        ['portNumber' => '443', 'portDescription' => 'HTTPS', 'riskLevel' => 'Low', 'machineCount' => 3],
        ['portNumber' => '22', 'portDescription' => 'SSH', 'riskLevel' => 'Medium', 'machineCount' => 1],
        ['portNumber' => '3389', 'portDescription' => 'RDP', 'riskLevel' => 'High', 'machineCount' => 2],
    ];

    $ports = array_slice($portData, 0, $count);

    $mock = test()->mock(CyrismaService::class);
    $mock->shouldReceive('forStore')->andReturn($mock);
    $mock->shouldReceive('getOpenPortsByAssetType')
        ->with($expectedAssetType)
        ->andReturn($ports);
}

describe('mount', function () {
    it('loads open ports on mount', function () {
        mockCyrismaOpenPorts(4);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->assertSet('assetType', '')
            ->assertSet('currentPage', 1)
            ->assertCount('openPorts', 4);
    });

    it('shows empty state when no open ports exist', function () {
        mockCyrismaOpenPorts(0);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->assertCount('openPorts', 0)
            ->assertSee('No open ports found.');
    });

    it('handles missing store gracefully', function () {
        app()->instance('currentStore', 99999);

        $mock = test()->mock(CyrismaService::class);
        $mock->shouldNotReceive('forStore');

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->assertCount('openPorts', 0);
    });
});

describe('asset type filtering', function () {
    it('reloads data when asset type changes', function () {
        $mock = test()->mock(CyrismaService::class);
        $mock->shouldReceive('forStore')->andReturn($mock);
        $mock->shouldReceive('getOpenPortsByAssetType')
            ->with('')
            ->once()
            ->andReturn([
                ['portNumber' => '135', 'portDescription' => 'DCE endpoint resolution', 'riskLevel' => 'Low', 'machineCount' => 2],
            ]);
        $mock->shouldReceive('getOpenPortsByAssetType')
            ->with('internal')
            ->once()
            ->andReturn([
                ['portNumber' => '135', 'portDescription' => 'DCE endpoint resolution', 'riskLevel' => 'Low', 'machineCount' => 1],
                ['portNumber' => '445', 'portDescription' => 'Microsoft-DS', 'riskLevel' => 'Medium', 'machineCount' => 1],
            ]);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->assertCount('openPorts', 1)
            ->set('assetType', 'internal')
            ->assertSet('assetType', 'internal')
            ->assertCount('openPorts', 2);
    });

    it('resets to first page when asset type changes', function () {
        $mock = test()->mock(CyrismaService::class);
        $mock->shouldReceive('forStore')->andReturn($mock);
        $mock->shouldReceive('getOpenPortsByAssetType')->andReturn([
            ['portNumber' => '135', 'portDescription' => 'DCE endpoint resolution', 'riskLevel' => 'Low', 'machineCount' => 2],
            ['portNumber' => '139', 'portDescription' => 'NETBIOS Session Service', 'riskLevel' => 'Medium', 'machineCount' => 1],
            ['portNumber' => '445', 'portDescription' => 'Microsoft-DS', 'riskLevel' => 'Medium', 'machineCount' => 1],
            ['portNumber' => '5357', 'portDescription' => 'Web Services for Devices', 'riskLevel' => 'Low', 'machineCount' => 2],
            ['portNumber' => '80', 'portDescription' => 'HTTP', 'riskLevel' => 'High', 'machineCount' => 3],
            ['portNumber' => '443', 'portDescription' => 'HTTPS', 'riskLevel' => 'Low', 'machineCount' => 3],
            ['portNumber' => '22', 'portDescription' => 'SSH', 'riskLevel' => 'Medium', 'machineCount' => 1],
            ['portNumber' => '3389', 'portDescription' => 'RDP', 'riskLevel' => 'High', 'machineCount' => 2],
        ]);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->call('nextPage')
            ->assertSet('currentPage', 2)
            ->set('assetType', 'internal')
            ->assertSet('currentPage', 1);
    });
});

describe('pagination', function () {
    it('paginates results with 5 per page', function () {
        mockCyrismaOpenPorts(8);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->assertCount('openPorts', 8)
            ->assertSee('135')
            ->assertSee('HTTP')
            ->assertDontSee('SSH')
            ->assertDontSee('RDP');
    });

    it('navigates to next page', function () {
        mockCyrismaOpenPorts(8);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->call('nextPage')
            ->assertSet('currentPage', 2)
            ->assertSee('3389')
            ->assertDontSee('135');
    });

    it('navigates to previous page', function () {
        mockCyrismaOpenPorts(8);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->call('nextPage')
            ->assertSet('currentPage', 2)
            ->call('previousPage')
            ->assertSet('currentPage', 1);
    });

    it('does not go below page 1', function () {
        mockCyrismaOpenPorts(4);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->call('previousPage')
            ->assertSet('currentPage', 1);
    });

    it('goes to a specific page', function () {
        mockCyrismaOpenPorts(8);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->call('gotoPage', 2)
            ->assertSet('currentPage', 2);
    });

    it('does not show pagination when results fit on one page', function () {
        mockCyrismaOpenPorts(4);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->assertDontSee('Previous')
            ->assertDontSee('Next');
    });

    it('shows pagination when results exceed one page', function () {
        mockCyrismaOpenPorts(8);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->assertSee('Previous')
            ->assertSee('Next');
    });
});

describe('view rendering', function () {
    it('displays port details in the table', function () {
        mockCyrismaOpenPorts(4);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->assertSee('135')
            ->assertSee('DCE endpoint resolution')
            ->assertSee('NETBIOS Session Service')
            ->assertSee('Microsoft-DS');
    });

    it('displays machine count', function () {
        mockCyrismaOpenPorts(1);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->assertSee('2');
    });

    it('renders the asset type dropdown', function () {
        mockCyrismaOpenPorts(0);

        Livewire::actingAs($this->consultant)
            ->test(OpenPorts::class)
            ->assertSee('All Asset Types')
            ->assertSee('Internal Authenticated')
            ->assertSee('External - IP Addresses');
    });
});
