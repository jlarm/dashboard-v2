<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Sds;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sds>
 */
class SdsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'manufacturer' => $this->faker->company(),
            'keywords' => $this->faker->words(3),
            'file_name' => $this->faker->slug().'.pdf',
        ];
    }
}
