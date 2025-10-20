<?php

namespace Tests;

use App\Models\Dealership;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Use test_ prefix for tenant databases
        config(['tenancy.database.prefix' => 'test_tenant_']);
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
