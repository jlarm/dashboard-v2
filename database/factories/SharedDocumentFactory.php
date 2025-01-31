<?php

namespace Database\Factories;

use App\Models\SharedDocument;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SharedDocumentFactory extends Factory
{
    protected $model = SharedDocument::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ];
    }
}
