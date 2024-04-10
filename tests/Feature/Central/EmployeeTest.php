<?php

use App\Models\User;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DepartmentSeeder::class);
    $this->seed(RoleAndPermissionSeeder::class);

    $admin = User::create([
        'name' => 'John Doe',
        'email' => 'jdoe@email.com',
        'phone' => '9876543211',
        'email_verified_at' => now(),
        'password' => bcrypt('password'),
    ]);

    $consultant = User::create([
        'name' => 'Jane Doe',
        'email' => 'janedoe@email.com',
        'phone' => '9876543212',
        'email_verified_at' => now(),
        'password' => bcrypt('password'),
    ]);

    $admin->assignRole('super-admin');
    $consultant->assignRole('Consultant');

    $this->admin = $admin;
    $this->consultant = $consultant;
});

test('consultant cannot access employees', function () {
    $this->actingAs($this->consultant);

    $response = $this->get('/employees');

    $response->assertStatus(403);
});

test('admin can access employees', function () {
    $this->actingAs($this->admin);

    $response = $this->get('/employees');

    $response->assertOk()
        ->assertSee('Employees');
});

test('admin can see add employee button', function () {
    $this->actingAs($this->admin);

    $response = $this->get('/employees');

    $response->assertOk()
        ->assertSee('Add Employee');
});
