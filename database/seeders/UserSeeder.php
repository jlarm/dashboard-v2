<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'department_id' => $this->faker()->numberBetween(1, 5),
            'store_id' => $this->faker()->numberBetween(1, 2),
            'name' => $this->faker()->name,
            'email' => $this->faker()->email,
            'phone' => $this->faker()->phoneNumber,
            'password' => Hash::make('password'),
        ]);

        $user->assignRole($this->faker()->randomElement(['manager', 'employee']));
    }
}
