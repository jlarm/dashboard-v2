<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Dealership;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Force testing database configuration
        config([
            'database.connections.mysql.database' => 'dashboard_testing',
            'tenancy.database.prefix' => 'test_tenant_',
        ]);

        // Reconnect to apply new config
        \Illuminate\Support\Facades\DB::purge('mysql');
        \Illuminate\Support\Facades\DB::reconnect('mysql');

        // Verify we're using the testing database
        $currentDb = \Illuminate\Support\Facades\DB::connection()->getDatabaseName();
        if ($currentDb !== 'dashboard_testing') {
            throw new RuntimeException(
                "SAFETY CHECK FAILED: Tests must use 'dashboard_testing' database, currently using: {$currentDb}. ".
                'Environment: '.env('DB_DATABASE').' | Config: '.config('database.connections.mysql.database')
            );
        }
    }

    protected function createTenant(array $data = []): Dealership
    {
        $id = $data['id'] ?? 'test-'.uniqid();
        $domain = $data['domain'] ?? $id.'.localhost';

        $owner = $data['owner'] ?? User::factory()->create();

        $dealership = Dealership::create([
            'id' => $id,
            'name' => $data['name'] ?? 'Test Dealership',
            'user_id' => $owner->id,
        ]);

        $dealership->domains()->create(['domain' => $domain]);

        return $dealership;
    }

    protected function seedRolesAndPermissions(): void
    {
        $this->seed(RoleAndPermissionSeeder::class);
    }
}
