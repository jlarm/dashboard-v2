<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FirstUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->create([
            'name' => 'Joe Lohr',
            'email' => 'jlohr@autorisknow.com',
            'phone' => '2243586930',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $terry = User::query()->create([
            'name' => 'Terry Dortch',
            'slug' => 'terry-dortch',
            'email' => 'tdortch@autorisknow.com',
            'phone' => '8156704651',
            'email_verified_at' => now(),
            'password' => bcrypt('AutorisknowTD!'),
        ]);

        $mike = User::query()->create([
            'name' => 'Mike Backer',
            'slug' => 'mike-backer',
            'email' => 'mbacker@autorisknow.com',
            'phone' => '8043823021',
            'email_verified_at' => now(),
            'password' => bcrypt('AutorisknowMB!'),
        ]);

        $user->assignRole('super-admin');
        $terry->assignRole('super-admin');
        $mike->assignRole('super-admin');
    }
}
