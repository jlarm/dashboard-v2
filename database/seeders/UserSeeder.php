<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Joe Lohr',
            'email' => 'jlohr@autorisknow.com',
            'phone' => '2243586930',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $terry = User::create([
            'name' => 'Terry Dortch',
            'slug' => 'terry-dortch',
            'email' => 'tdortch@autorisknow.com',
            'phone' => '1234567899',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $cole = User::create([
            'name' => 'Cole Dach',
            'slug' => 'cole-dach',
            'email' => 'cdach@example.org',
            'phone' => '1234567899',
            'department_id' => 3,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $shannon = User::create([
            'name' => 'Shannon Weimann',
            'slug' => 'shannon-weimann',
            'email' => 'weimann.shannon@example.net',
            'phone' => '1234567899',
            'department_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $shannon->assignRole('Employee');
        $cole->assignRole('Manager');
        $terry->assignRole('Consultant');
        $admin->assignRole('super-admin');

        $users = User::factory()->count(50)->create();
        foreach ($users as $user) {
            $user->assignRole('Employee');
            $user->stores()->sync(fake()->randomElements([1, 2, 3], fake()->numberBetween(1, 3)));
        }
    }
}
