<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DepartmentSeeder::class);
    $this->seed(RoleAndPermissionSeeder::class);

    $user = User::create([
        'name' => 'John Doe',
        'email' => 'jdoe@email.com',
        'phone' => '9876543211',
        'email_verified_at' => now(),
        'password' => bcrypt('password'),
    ]);

    $user->assignRole('super-admin');
});

test('guest sees login page', function () {
    $response = $this->get('/login');

    $response
        ->assertOk()
        ->assertSee('Sign in to your account');
});

test('user can authenticate', function () {

    $this->assertDatabaseHas('users', [
        'email' => 'jdoe@email.com',
    ]);

    $response = $this->actingAs(User::first())->post('/login', [
        'email' => 'jdoe@email.com',
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
});

test('user cannot authenticate with invalid password', function () {
    $this->post('/login', [
        'email' => 'asd@jd.com',
        'password' => 'password',
    ]);

    $this->assertGuest();
});
