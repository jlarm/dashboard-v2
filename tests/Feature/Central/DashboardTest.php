<?php

use App\Models\User;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DepartmentSeeder::class);
    $this->seed(RoleAndPermissionSeeder::class);
});

test('guest redirects to login page', function () {
    $this->assertGuest();

    $response = $this->get('/dashboard');

    $this->assertGuest();

    $response->assertRedirect('/login');
});

test('logged in super-admin can see dashboard', function () {
    $superAdmin = User::factory()->create();
    $superAdmin->assignRole('super-admin');

    $response = $this->actingAs($superAdmin)->get('/dashboard');

    $response
        ->assertOk()
        ->assertSee('Upcoming Events')
        ->assertSee('Add Event');
});

test('logged in consultant can see dashboard', function () {
    $consultant = User::factory()->create();
    $consultant->assignRole('Consultant');

    $response = $this->actingAs($consultant)->get('/dashboard');

    $response->assertOk()
        ->assertSee('Upcoming Events')
        ->assertDontSee('Add Event');
});
