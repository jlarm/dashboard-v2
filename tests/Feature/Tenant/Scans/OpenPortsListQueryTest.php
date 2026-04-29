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
    $mock->shouldReceive('forStore')->once()->andReturn($mock);
    $mock->shouldReceive('getOpenPortsByAssetType')
        ->once()
        ->with('')
        ->andReturn([
            ['portNumber' => '135', 'portDescription' => 'DCE endpoint resolution', 'riskLevel' => 'Low', 'machineCount' => 2],
            ['portNumber' => '80', 'portDescription' => 'HTTP', 'riskLevel' => 'High', 'machineCount' => 3],
        ]);

    $result = app(GetOpenPortsList::class)->handle($this->store, null);

    expect($result)->toHaveCount(2);
    expect($result[0])->toMatchArray([
        'port_number' => '135',
        'port_description' => 'DCE endpoint resolution',
        'risk_level' => 'Low',
        'machine_count' => 2,
    ]);
    expect($result[1]['risk_level'])->toBe('High');
});

it('passes the asset type through to the Cyrisma service', function (): void {
    $mock = $this->mock(CyrismaService::class);
    $mock->shouldReceive('forStore')->andReturn($mock);
    $mock->shouldReceive('getOpenPortsByAssetType')
        ->once()
        ->with('internal')
        ->andReturn([
            ['portNumber' => '445', 'portDescription' => 'Microsoft-DS', 'riskLevel' => 'Medium', 'machineCount' => 1],
        ]);

    $result = app(GetOpenPortsList::class)->handle($this->store, 'internal');

    expect($result)->toHaveCount(1);
    expect($result[0]['port_number'])->toBe('445');
});

it('returns an empty array when the service returns no ports', function (): void {
    $mock = $this->mock(CyrismaService::class);
    $mock->shouldReceive('forStore')->andReturn($mock);
    $mock->shouldReceive('getOpenPortsByAssetType')->andReturn([]);

    $result = app(GetOpenPortsList::class)->handle($this->store, null);

    expect($result)->toBe([]);
});

it('treats empty descriptions as null', function (): void {
    $mock = $this->mock(CyrismaService::class);
    $mock->shouldReceive('forStore')->andReturn($mock);
    $mock->shouldReceive('getOpenPortsByAssetType')->andReturn([
        ['portNumber' => '12345', 'portDescription' => '', 'riskLevel' => 'Low', 'machineCount' => 1],
    ]);

    $result = app(GetOpenPortsList::class)->handle($this->store, null);

    expect($result[0]['port_description'])->toBeNull();
});
