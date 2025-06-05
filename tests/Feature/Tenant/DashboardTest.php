<?php

declare(strict_types=1);

use App\Models\Dealership;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\CourseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Stancl\Tenancy\Facades\Tenancy;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
});

it('can view tenant dashboard as dealer admin', function () {
    // Create a user with dealer admin role
    $user = User::factory()->create();
    $user->assignRole('super-admin');

    // Create a tenant (dealership) with the user
    $dealership = Dealership::create([
        'id' => 'test-dealership',
        'name' => 'Test Dealership',
        'phone' => '1234567890',
        'user_id' => $user->id,
    ]);

    // Associate user with the dealership
    $dealership->users()->attach($user->id);

    // Initialize tenant - this will run migrations automatically
    tenancy()->initialize($dealership);

    // Access the tenant database to run seeders
    tenancy()->runForTenant($dealership, function () {
        $this->seed(DepartmentSeeder::class);
        $this->seed(CourseSeeder::class);
    });

    // Access the tenant dashboard
    $response = test()
        ->actingAs($user)
        ->get('/dashboard');

    // Verify the dashboard is accessible
    $response->assertOk();

    // Verify key elements from the dashboard are present
    $response->assertSee('Test Dealership');

    // Check for dashboard components
    $response->assertSeeInOrder([
        '<x-dealer-app>',
        'dashboard',
    ]);

    // Clean up - end tenant context
    tenancy()->end();
});

it('can view tenant dashboard with multiple locations', function () {
    // Create a user with store edit permissions
    $user = User::factory()->create();
    $user->assignRole('dealer-admin');
    $user->givePermissionTo('edit-stores');

    // Create a tenant with locations
    $dealership = Dealership::create([
        'id' => 'test-dealer-group',
        'name' => 'Test Dealer Group',
        'phone' => '1234567890',
        'data' => ['locations' => true],
        'user_id' => $user->id,
    ]);

    // Associate user with the dealership
    $dealership->users()->attach($user->id);

    // Initialize tenant - this will run migrations automatically
    tenancy()->initialize($dealership);

    // Access the tenant database to run seeders
    tenancy()->runForTenant($dealership, function () {
        $this->seed(DepartmentSeeder::class);
        $this->seed(CourseSeeder::class);
    });

    // Access the tenant dashboard
    $response = test()
        ->actingAs($user)
        ->get('/dashboard');

    // Verify the dashboard is accessible
    $response->assertOk();

    // Verify multi-location components are present
    $response->assertSee('stores-list');

    // Clean up - end tenant context
    tenancy()->end();
});

it('can view tenant dashboard as employee', function () {
    // Create a user with basic employee permissions
    $user = User::factory()->create();
    $user->assignRole('employee');

    // Create an admin user for the dealership
    $adminUser = User::factory()->create();
    $adminUser->assignRole('dealer-admin');

    // Create a tenant
    $dealership = Dealership::create([
        'id' => 'test-dealer-employee',
        'name' => 'Test Dealership Employee',
        'phone' => '1234567890',
        'user_id' => $adminUser->id, // Use the admin user as the owner
    ]);

    // Associate both users with the dealership
    $dealership->users()->attach([$user->id, $adminUser->id]);

    // Initialize tenant - this will run migrations automatically
    tenancy()->initialize($dealership);

    // Access the tenant database to run seeders
    tenancy()->runForTenant($dealership, function () {
        $this->seed(DepartmentSeeder::class);
        $this->seed(CourseSeeder::class);
    });

    // Access the tenant dashboard
    $response = test()
        ->actingAs($user)
        ->get('/dashboard');

    // Verify the dashboard is accessible
    $response->assertOk();

    // Verify employee-specific view is present
    $response->assertSee('course-list');

    // Clean up - end tenant context
    tenancy()->end();
});
