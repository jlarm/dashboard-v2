<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/
use App\Models\Dealer\Store;
use App\Models\Dealership;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TenantTestCase;
use Tests\TestCase;

uses(
    TestCase::class,
    RefreshDatabase::class,
)->in('Feature/Auth', 'Feature/Central');

uses(TenantTestCase::class)->in('Feature/Tenant');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', fn () => $this->toBe(1));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function asSuperAdmin(): TestCase
{
    $user = User::factory()->create();

    $user->assignRole('super-admin');

    return test()->actingAs($user);
}

function asConsultant(): TestCase
{
    $user = User::factory()->create();

    $user->assignRole('Consultant');

    return test()->actingAs($user);
}

function setupCentralDatabase(): void
{
    // Verify we're using the testing database
    $currentDb = DB::connection()->getDatabaseName();
    throw_if($currentDb !== 'dashboard_testing', new RuntimeException(
        "SAFETY CHECK FAILED: Tests must use 'dashboard_testing' database, currently using: {$currentDb}. ".
        'Check your phpunit.xml configuration.'
    ));

    config([
        'tenancy.queue_database_creation' => false,
        'tenancy.queue_database_deletion' => false,
        'tenancy.delete_database_after_tenant_deletion' => true,
        'tenancy.exempt_domains' => ['127.0.0.1', 'localhost'],
    ]);

    // Drop ONLY test tenant databases from failed runs
    $databases = DB::select('SHOW DATABASES LIKE "test_tenant_%"');
    foreach ($databases as $db) {
        $dbName = $db->{'Database (test_tenant_%)'};
        DB::statement("DROP DATABASE IF EXISTS `{$dbName}`");
    }

    // Run central migrations on testing database
    Artisan::call('migrate:fresh', [
        '--path' => 'database/migrations',
        '--realpath' => false,
    ]);

    // Run Telescope migrations
    Artisan::call('migrate', [
        '--path' => 'vendor/laravel/telescope/database/migrations',
        '--realpath' => true,
    ]);

    Dealership::query()->delete();

    Artisan::call('db:seed', ['--class' => RoleAndPermissionSeeder::class]);
}

function teardownTenants(): void
{
    if (tenancy()->initialized) {
        tenancy()->end();
    }

    // Drop ONLY test tenant databases
    $databases = DB::select('SHOW DATABASES LIKE "test_tenant_%"');
    foreach ($databases as $db) {
        $dbName = $db->{'Database (test_tenant_%)'};
        DB::statement("DROP DATABASE IF EXISTS `{$dbName}`");
    }

    Dealership::query()->each(function ($dealership): void {
        $storagePath = storage_path("framework/tenants/{$dealership->id}");
        if (is_dir($storagePath)) {
            exec('rm -rf '.escapeshellarg($storagePath));
        }
    });

    Dealership::query()->delete();

    DB::purge('tenant');
}

/**
 * Create a new dealership tenant and return both dealership + tenant user
 */
function createDealershipTenant(?User $owner = null): array
{
    $owner ??= User::factory()->create();
    $tenantId = 'acme-'.str()->lower(str()->random(8));

    $dealership = Dealership::query()->create([
        'id' => $tenantId,
        'name' => 'Acme '.$tenantId,
        'user_id' => $owner->id,
    ]);

    $dealership->domains()->create(['domain' => $tenantId.'.localhost']);

    $dealership->run(function (): void {
        Store::query()->create([
            'name' => 'Test Store',
            'slug' => 'test-store',
        ]);

        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--realpath' => false,
        ]);
    });

    // Create tenant user
    $consultant = $dealership->run(fn () => User::query()->create([
        'name' => $owner->name,
        'email' => $owner->email,
        'password' => $owner->password,
    ]));

    $dealership->run(fn () => $consultant->assignRole('Consultant'));

    return [$dealership, $consultant];
}
