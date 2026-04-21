<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'url' => $this->faker->url(),
            'file_name' => null,
        ];
    }

    public function withFile(): self
    {
        return $this->state(fn (): array => [
            'url' => null,
            'file_name' => $this->faker->slug().'.pdf',
        ]);
    }
}
