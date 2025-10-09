<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\Dealership;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

beforeEach(fn () => setupCentralDatabase());
afterEach(fn () => teardownTenants());

it('isolates cache between different tenants using tenant_cache_remember', function () {
    // Create two separate dealerships
    $owner1 = User::factory()->create(['email' => 'owner1@central.com']);
    $owner2 = User::factory()->create(['email' => 'owner2@central.com']);

    [$dealership1, $consultant1] = createDealershipTenant($owner1);

    $dealership2 = Dealership::create([
        'id' => 'widgets',
        'name' => 'Widgets',
        'user_id' => $owner2->id,
    ]);
    $dealership2->domains()->create(['domain' => 'widgets.localhost']);
    $dealership2->run(function () {
        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--realpath' => false,
        ]);
    });
    $consultant2 = $dealership2->run(fn () => User::create([
        'name' => $owner2->name,
        'email' => $owner2->email,
        'password' => $owner2->password,
    ]));
    $dealership2->run(fn () => $consultant2->assignRole('Consultant'));

    // Set cache value for dealership 1
    $dealership1->run(function () {
        $value = tenant_cache_remember('test_key', now()->addHour(), fn () => 'acme_value');

        expect($value)->toBe('acme_value');
    });

    // Set cache value for dealership 2 with the same key
    $dealership2->run(function () {
        $value = tenant_cache_remember('test_key', now()->addHour(), fn () => 'widgets_value');

        expect($value)->toBe('widgets_value');
    });

    // Verify dealership 1 still has its own value (not affected by dealership 2)
    $dealership1->run(function () {
        $value = tenant_cache_remember('test_key', now()->addHour(), function () {
            throw new Exception('Cache should hit, not miss');
        });

        expect($value)->toBe('acme_value', 'Dealership 1 should have its own cached value');
    });

    // Verify dealership 2 still has its own value (not affected by dealership 1)
    $dealership2->run(function () {
        $value = tenant_cache_remember('test_key', now()->addHour(), function () {
            throw new Exception('Cache should hit, not miss');
        });

        expect($value)->toBe('widgets_value', 'Dealership 2 should have its own cached value');
    });
});

it('prevents cache key collisions between tenants', function () {
    $owner1 = User::factory()->create(['email' => 'owner1@central.com']);
    $owner2 = User::factory()->create(['email' => 'owner2@central.com']);

    [$dealership1, $consultant1] = createDealershipTenant($owner1);

    $dealership2 = Dealership::create([
        'id' => 'dealer2',
        'name' => 'Dealer 2',
        'user_id' => $owner2->id,
    ]);
    $dealership2->domains()->create(['domain' => 'dealer2.localhost']);
    $dealership2->run(function () {
        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--realpath' => false,
        ]);
    });

    // Store different data with the same cache key in both tenants
    $dealership1->run(function () {
        tenant_cache_remember('user_data', now()->addHour(), fn () => ['name' => 'John from Dealer 1']);
    });

    $dealership2->run(function () {
        tenant_cache_remember('user_data', now()->addHour(), fn () => ['name' => 'Jane from Dealer 2']);
    });

    // Verify no data leakage
    $dealer1Data = $dealership1->run(fn () => tenant_cache_remember('user_data', now()->addHour(), fn () => []));
    $dealer2Data = $dealership2->run(fn () => tenant_cache_remember('user_data', now()->addHour(), fn () => []));

    expect($dealer1Data['name'])->toBe('John from Dealer 1');
    expect($dealer2Data['name'])->toBe('Jane from Dealer 2');
    expect($dealer1Data['name'])->not->toBe($dealer2Data['name']);
});

it('properly generates tenant-prefixed cache keys', function () {
    [$dealership, $consultant] = createDealershipTenant();

    $dealership->run(function () {
        $key = tenant_cache_key('my_cache_key');

        expect($key)->toBe('tenant_acme_my_cache_key');
        expect($key)->toContain('tenant_');
        expect($key)->toContain('acme');
    });
});

it('uses central prefix when outside tenant context', function () {
    $key = tenant_cache_key('central_key');

    expect($key)->toBe('tenant_central_central_key');
    expect($key)->toContain('central');
});

it('isolates store-specific cache between tenants', function () {
    $owner1 = User::factory()->create(['email' => 'owner1@test.com']);
    $owner2 = User::factory()->create(['email' => 'owner2@test.com']);

    $dealership1 = Dealership::create([
        'id' => 'dealer-a',
        'name' => 'Dealer A',
        'user_id' => $owner1->id,
    ]);
    $dealership1->domains()->create(['domain' => 'dealer-a.localhost']);
    $dealership1->run(function () {
        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--realpath' => false,
        ]);
    });

    $dealership2 = Dealership::create([
        'id' => 'dealer-b',
        'name' => 'Dealer B',
        'user_id' => $owner2->id,
    ]);
    $dealership2->domains()->create(['domain' => 'dealer-b.localhost']);
    $dealership2->run(function () {
        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--realpath' => false,
        ]);
    });

    // Create stores in each tenant
    $dealership1->run(function () {
        $store = Store::create([
            'name' => 'Acme Store',
            'slug' => 'acme-store',
        ]);

        tenant_cache_remember('store_data_'.$store->id, now()->addHour(), fn () => [
            'store_name' => 'Acme Store',
            'inventory' => 100,
        ]);
    });

    $dealership2->run(function () {
        $store = Store::create([
            'name' => 'Widgets Store',
            'slug' => 'widgets-store',
        ]);

        tenant_cache_remember('store_data_'.$store->id, now()->addHour(), fn () => [
            'store_name' => 'Widgets Store',
            'inventory' => 200,
        ]);
    });

    // Verify each tenant only sees their own store data
    $store1Data = $dealership1->run(function () {
        $store = Store::first();

        return tenant_cache_remember('store_data_'.$store->id, now()->addHour(), fn () => []);
    });

    $store2Data = $dealership2->run(function () {
        $store = Store::first();

        return tenant_cache_remember('store_data_'.$store->id, now()->addHour(), fn () => []);
    });

    expect($store1Data['store_name'])->toBe('Acme Store');
    expect($store1Data['inventory'])->toBe(100);
    expect($store2Data['store_name'])->toBe('Widgets Store');
    expect($store2Data['inventory'])->toBe(200);
});
