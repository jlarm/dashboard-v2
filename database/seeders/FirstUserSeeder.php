<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FirstUserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Joe Lohr',
            'email' => 'jlohr@autorisknow.com',
            'phone' => '2243586930',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('super-admin');
    }
}
