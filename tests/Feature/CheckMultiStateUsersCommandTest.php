<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    [$this->tenant, $this->consultant] = createDealershipTenant();
});

afterEach(function (): void {
    teardownTenants();
});

it('lists users assigned to stores in multiple states', function (): void {
    $this->tenant->run(function (): void {
        $tnStore = Store::query()->create(['name' => 'TN Store', 'state' => 'Tennessee']);
        $txStore = Store::query()->create(['name' => 'TX Store', 'state' => 'Texas']);

        $user = User::factory()->create(['name' => 'Multi State User', 'email' => 'multi-state@test.com']);
        $user->stores()->attach([$tnStore->id, $txStore->id]);
    });

    Artisan::call('users:check-multi-state', ['--tenant' => $this->tenant->id]);
    $output = Artisan::output();

    expect($output)->toContain('Multi State User')
        ->and($output)->toContain('multi-state@test.com')
        ->and($output)->toContain('TN Store')
        ->and($output)->toContain('TX Store')
        ->and($output)->toContain('Total multi-state users found: 1');
});

it('does not list users assigned to multiple stores in the same state', function (): void {
    $this->tenant->run(function (): void {
        $store1 = Store::query()->create(['name' => 'TN Store 1', 'state' => 'Tennessee']);
        $store2 = Store::query()->create(['name' => 'TN Store 2', 'state' => 'Tennessee']);

        $user = User::factory()->create(['name' => 'Same State User', 'email' => 'same-state@test.com']);
        $user->stores()->attach([$store1->id, $store2->id]);
    });

    Artisan::call('users:check-multi-state', ['--tenant' => $this->tenant->id]);
    $output = Artisan::output();

    expect($output)->not->toContain('Same State User')
        ->and($output)->toContain('Total multi-state users found: 0');
});

it('does not list users assigned to only one store', function (): void {
    $this->tenant->run(function (): void {
        $store = Store::query()->create(['name' => 'Single Store', 'state' => 'Tennessee']);

        $user = User::factory()->create(['name' => 'Single Store User', 'email' => 'single-store@test.com']);
        $user->stores()->attach($store->id);
    });

    Artisan::call('users:check-multi-state', ['--tenant' => $this->tenant->id]);
    $output = Artisan::output();

    expect($output)->not->toContain('Single Store User')
        ->and($output)->toContain('Total multi-state users found: 0');
});

it('filters to a specific tenant when --tenant is given', function (): void {
    [$otherTenant] = createDealershipTenant();

    $this->tenant->run(function (): void {
        $tnStore = Store::query()->create(['name' => 'TN Store', 'state' => 'Tennessee']);
        $txStore = Store::query()->create(['name' => 'TX Store', 'state' => 'Texas']);

        $user = User::factory()->create(['name' => 'Target Tenant User', 'email' => 'target-tenant@test.com']);
        $user->stores()->attach([$tnStore->id, $txStore->id]);
    });

    $otherTenant->run(function (): void {
        $caStore = Store::query()->create(['name' => 'CA Store', 'state' => 'California']);
        $nyStore = Store::query()->create(['name' => 'NY Store', 'state' => 'New York']);

        $user = User::factory()->create(['name' => 'Other Tenant User', 'email' => 'other-tenant@test.com']);
        $user->stores()->attach([$caStore->id, $nyStore->id]);
    });

    Artisan::call('users:check-multi-state', ['--tenant' => $this->tenant->id]);
    $output = Artisan::output();

    expect($output)->toContain('Target Tenant User')
        ->and($output)->not->toContain('Other Tenant User');
});
