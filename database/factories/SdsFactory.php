<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class SdsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
            'name' => $this->faker->name(),
            'product_identifier' => $this->faker->word(),
            'product_identification_number' => $this->faker->word(),
            'manufacturer' => $this->faker->word(),
            'cas_no' => $this->faker->word(),
            'common_name' => $this->faker->name(),
        ];
    }
}
