<?php

declare(strict_types=1);

use App\Models\Dealership;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    config([
        'tenancy.queue_database_creation' => false,
        'tenancy.queue_database_deletion' => false,
        'tenancy.delete_database_after_tenant_deletion' => true,
        'tenancy.exempt_domains' => ['127.0.0.1', 'localhost'],
    ]);

    // Drop ALL tenant databases that might exist from failed test runs BEFORE migrations
    $databases = DB::select('SHOW DATABASES LIKE "dealership_%"');
    foreach ($databases as $db) {
        $dbName = $db->{'Database (dealership_%)'};
        DB::statement("DROP DATABASE IF EXISTS `{$dbName}`");
    }

    // Run only central migrations (excluding tenant directory)
    $this->artisan('migrate:fresh', [
        '--path' => 'database/migrations',
        '--realpath' => false,
    ]);

    // Clean up any existing dealership records
    Dealership::query()->delete();

    $this->seed(RoleAndPermissionSeeder::class);
});

afterEach(function () {
    if (tenancy()->initialized) {
        tenancy()->end();
    }

    // Drop ALL tenant databases
    $databases = DB::select('SHOW DATABASES LIKE "dealership_%"');
    foreach ($databases as $db) {
        $dbName = $db->{'Database (dealership_%)'};
        DB::statement("DROP DATABASE IF EXISTS `{$dbName}`");
    }

    // Clean up tenant storage directories
    $dealerships = Dealership::all();
    foreach ($dealerships as $dealership) {
        $storagePath = storage_path("framework/tenants/{$dealership->id}");
        if (is_dir($storagePath)) {
            exec("rm -rf " . escapeshellarg($storagePath));
        }
    }

    // Delete dealership records (databases already dropped above)
    Dealership::query()->delete();

    DB::purge('tenant');
});

it('prevents users from different tenants from accessing each others data', function () {
    // Create central users who own the dealerships
    $owner1 = User::factory()->create(['email' => 'owner1@central.com']);
    $owner2 = User::factory()->create(['email' => 'owner2@central.com']);

    // Create dealership 1 in central database
    $dealership1 = Dealership::create([
        'id' => 'acme',
        'name' => 'Acme',
        'user_id' => $owner1->id,
    ]);
    $dealership1->domains()->create(['domain' => 'acme.localhost']);

    // Create dealership 2 in central database
    $dealership2 = Dealership::create([
        'id' => 'widgets',
        'name' => 'Widgets',
        'user_id' => $owner2->id,
    ]);
    $dealership2->domains()->create(['domain' => 'widgets.localhost']);

    // Create tenant users in dealership 1's database
    $dealership1->run(function () {
        User::create([
            'name' => 'John Doe',
            'email' => 'john@acme.com',
            'password' => bcrypt('password'),
        ])->assignRole('super-admin');
    });

    // Create tenant users in dealership 2's database
    $dealership2->run(function () {
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@widgets.com',
            'password' => bcrypt('password'),
        ])->assignRole('super-admin');
    });

    $dealership1->run(function () {
        expect(User::count())->toBe(1, 'Dealership 1 should only have 1 user');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@acme.com',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'jane@widgets.com',
        ]);
    });

    $dealership2->run(function () {
        expect(User::count())->toBe(1, 'Dealership 2 should only have 1 user');

        $this->assertDatabaseHas('users', [
            'name' => 'Jane Smith',
            'email' => 'jane@widgets.com',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'john@acme.com',
        ]);
    });

    $usersInDealership1 = $dealership1->run(fn () => User::pluck('email')->toArray());
    $usersInDealership2 = $dealership2->run(fn () => User::pluck('email')->toArray());

    expect($usersInDealership1)
        ->not->toContain('jane@widgets.com', 'Dealership 1 should not see Dealership 2 users');

    expect($usersInDealership2)
        ->not->toContain('john@acme.com', 'Dealership 2 should not see Dealership 1 users');
});
