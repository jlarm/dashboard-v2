<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => null,
            'name' => 'John Doe',
            'email' => 'jdoe@email.com',
            'phone' => '9876543211',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];

    }

    public function configure(): Factory|UserFactory
    {
        return $this->afterCreating(function (User $user) {
            // Only assign role if roles exist (not during tenant isolation tests)
            if (\Spatie\Permission\Models\Role::where('name', 'super-admin')->exists()) {
                $user->assignRole('super-admin');
            }
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
