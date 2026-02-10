<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

abstract class TenantTestCase extends TestCase
{
    // Don't use DatabaseMigrations trait as it causes foreign key issues
    // Instead, we'll manually run migrations and drop the database on teardown

    /**
     * Create tenant and initialize tenancy?
     */
    protected bool $tenancy = true;

    /**
     * Should seed the tenant database?
     */
    protected bool $shouldSeed = false;

    /**
     * The tenant instance
     */
    protected $tenant;

    /**
     * The tenant user instance
     */
    protected $consultant;

    protected $manager;

    protected function setUp(): void
    {
        parent::setUp();

        // Parent TestCase already verifies we're using dashboard_testing and forces the config

        // Clean up any leftover test tenant databases from failed test runs
        $this->cleanupTestDatabases();

        // Run central migrations for the testing database
        $this->artisan('migrate:fresh', [
            '--database' => 'mysql',
        ]);

        // Seed roles in central database
        $this->seedRolesAndPermissions();

        if ($this->tenancy) {
            // Create tenant - this will automatically create the MySQL database
            // via the TenantCreated event in TenancyServiceProvider
            $this->tenant = $this->createTenant(['id' => 'test-tenant', 'domain' => 'test-tenant.localhost']);

            // Initialize tenancy - switches to tenant database connection
            tenancy()->initialize($this->tenant);

            // Run tenant migrations
            $this->artisan('migrate', [
                '--path' => 'database/migrations/tenant',
                '--realpath' => false,
            ]);

            // Seed roles and permissions in tenant database
            $this->seedRolesAndPermissions();

            // Create a test store (required by many tenant routes)
            Store::query()->create([
                'name' => 'Test Store',
                'slug' => 'test-store',
            ]);

            // Create tenant user
            $this->consultant = User::query()->create([
                'name' => 'Test User',
                'email' => 'test@test-tenant.localhost',
                'password' => bcrypt('password'),
            ]);

            $this->consultant->assignRole('Consultant');

            $this->manager = User::query()->create([
                'name' => 'Test Manager',
                'email' => 'tm@email.com',
                'password' => bcrypt('password'),
            ]);

            $this->manager->assignRole('Manager');

            // Refresh permissions cache after assigning roles
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            // Configure URL generation for tenant
            config(['app.url' => 'http://test-tenant.localhost']);

            /** @var UrlGenerator */
            $urlGenerator = url();
            $urlGenerator->forceRootUrl('http://test-tenant.localhost');

            $this->withServerVariables([
                'SERVER_NAME' => 'test-tenant.localhost',
                'HTTP_HOST' => 'test-tenant.localhost',
            ]);
        }
    }

    protected function tearDown(): void
    {
        if (tenancy()->initialized) {
            tenancy()->end();
        }

        // Delete the tenant, which will trigger the TenantDeleted event
        // and automatically drop the MySQL database
        if ($this->tenant !== null) {
            $this->tenant->delete();
        }

        parent::tearDown();
    }

    /**
     * Clean up any leftover test tenant databases from failed test runs
     */
    protected function cleanupTestDatabases(): void
    {
        $prefix = config('tenancy.database.prefix');
        $databases = DB::select("SHOW DATABASES LIKE '{$prefix}%'");

        foreach ($databases as $db) {
            $dbName = $db->{"Database ({$prefix}%)"};
            DB::statement("DROP DATABASE IF EXISTS `{$dbName}`");
        }
    }
}
