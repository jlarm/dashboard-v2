<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Sds;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SdsFactory extends Factory
{
    public function definition()
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'product_identifier' => $this->faker->word(),
            'product_identification_number' => $this->faker->word(),
            'manufacturer' => $this->faker->word(),
            'cas_no' => $this->faker->word(),
            'common_name' => $this->faker->name(),
        ];
    }
}
