<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\OshaQuestions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<OshaQuestions>
 */
class OshaQuestionsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question' => $this->faker->word(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ];
    }
}
