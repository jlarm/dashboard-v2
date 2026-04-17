<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Dealership;
use App\Models\User;
use App\Services\UserCourseService;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        // Force testing database configuration
        config([
            'database.connections.mysql.database' => 'dashboard_testing',
            'tenancy.database.prefix' => 'test_tenant_',
            'services.mailgun.webhook_signing_key' => 'test-signing-key',
        ]);

        // Reconnect to apply new config
        DB::purge('mysql');
        DB::reconnect('mysql');

        // Verify we're using the testing database
        $currentDb = DB::connection()->getDatabaseName();
        throw_if($currentDb !== 'dashboard_testing', new RuntimeException(
            "SAFETY CHECK FAILED: Tests must use 'dashboard_testing' database, currently using: {$currentDb}. ".
            'Environment: '.env('DB_DATABASE').' | Config: '.config('database.connections.mysql.database')
        ));

        app(UserCourseService::class)->clearAllCaches();
    }

    protected function createTenant(array $data = []): Dealership
    {
        $id = $data['id'] ?? 'test-'.uniqid();
        $domain = $data['domain'] ?? $id.'.localhost';

        $owner = $data['owner'] ?? User::factory()->create();

        $dealership = Dealership::query()->create([
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
