<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ViolationStatement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ViolationStatement>
 */
class ViolationStatementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'statement' => $this->faker->sentence(),
            'weight' => $this->faker->numberBetween(1, 10),
            'categories' => [\App\Enums\ViolationStatementCategory::Osha->value],
            'keywords' => $this->faker->words(3),
        ];
    }
}
