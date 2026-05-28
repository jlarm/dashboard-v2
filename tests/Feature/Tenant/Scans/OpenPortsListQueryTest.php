<?php

declare(strict_types=1);

use App\Domain\Tenant\Scans\Queries\GetOpenPortsList;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;

beforeEach(function (): void {
    $this->store = Store::query()->first();
});

it('returns open ports normalized to the snake_case Inertia shape', function (): void {
    $mock = $this->mock(CyrismaService::class);
    $mock->shouldReceive('forStore')->andReturn($mock);
    $mock->shouldReceive('getOpenPortsByAssetType')->with('internal')->andReturn([]);
    $mock->shouldReceive('getOpenPortsByAssetType')->with('external_ip')->andReturn([]);
    $mock->shouldReceive('getOpenPortsByAssetType')
        ->with('')
        ->andReturn([
            ['portNumber' => '135', 'portDescription' => 'DCE endpoint resolution', 'riskLevel' => 'Low', 'machineCount' => 2],
            ['portNumber' => '80', 'portDescription' => 'HTTP', 'riskLevel' => 'High', 'machineCount' => 3],
        ]);

    $result = resolve(GetOpenPortsList::class)->handle($this->store, null);

    expect($result['items'])->toHaveCount(2);
    expect($result['items'][0])->toMatchArray([
        'port_number' => '135',
        'port_description' => 'DCE endpoint resolution',
        'risk_level' => 'Low',
        'machine_count' => 2,
    ]);
    expect($result['items'][1]['risk_level'])->toBe('High');
    expect($result['available_asset_types'])->toBe([]);
});

it('passes the asset type through to the Cyrisma service', function (): void {
    $mock = $this->mock(CyrismaService::class);
    $mock->shouldReceive('forStore')->andReturn($mock);
    $mock->shouldReceive('getOpenPortsByAssetType')
        ->with('internal')
        ->andReturn([
            ['portNumber' => '445', 'portDescription' => 'Microsoft-DS', 'riskLevel' => 'Medium', 'machineCount' => 1],
        ]);
    $mock->shouldReceive('getOpenPortsByAssetType')->with('external_ip')->andReturn([]);

    $result = resolve(GetOpenPortsList::class)->handle($this->store, 'internal');

    expect($result['items'])->toHaveCount(1);
    expect($result['items'][0]['port_number'])->toBe('445');
    expect($result['available_asset_types'])->toBe(['internal']);
});

it('returns an empty array when the service returns no ports', function (): void {
    $mock = $this->mock(CyrismaService::class);
    $mock->shouldReceive('forStore')->andReturn($mock);
    $mock->shouldReceive('getOpenPortsByAssetType')->andReturn([]);

    $result = resolve(GetOpenPortsList::class)->handle($this->store, null);

    expect($result)->toBe([
        'items' => [],
        'available_asset_types' => [],
    ]);
});

it('treats empty descriptions as null', function (): void {
    $mock = $this->mock(CyrismaService::class);
    $mock->shouldReceive('forStore')->andReturn($mock);
    $mock->shouldReceive('getOpenPortsByAssetType')->with('internal')->andReturn([]);
    $mock->shouldReceive('getOpenPortsByAssetType')->with('external_ip')->andReturn([]);
    $mock->shouldReceive('getOpenPortsByAssetType')->with('')->andReturn([
        ['portNumber' => '12345', 'portDescription' => '', 'riskLevel' => 'Low', 'machineCount' => 1],
    ]);

    $result = resolve(GetOpenPortsList::class)->handle($this->store, null);

    expect($result['items'][0]['port_description'])->toBeNull();
});
