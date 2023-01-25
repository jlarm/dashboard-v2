<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

         $user = \App\Models\User::factory()->create([
             'name' => 'Joe Lohr',
             'email' => 'jlohr@autorisknow.com',
             'phone' => '2243586930',
             'password' => \Hash::make('password'),
         ]);

         $user->assignRole('super-admin');

    }
}
