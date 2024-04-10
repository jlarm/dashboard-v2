<?php

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

test('guest redirects to login page', function () {
    $this->assertGuest();

    $response = $this->get('/dashboard');

    $this->assertGuest();

    $response->assertRedirect('/login');
});

test('logged in user can see dashboard', function () {
   $response = $this->actingAs(User::first())->get('/dashboard');

    $response
        ->assertOk()
        ->assertSee('Upcoming Events');
});
