<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\SharedDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SharedDocument>
 */
class SharedDocumentFactory extends Factory
{
    protected $model = SharedDocument::class;

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
            'file_name' => 'shared-documents/'.$this->faker->slug().'.pdf',
        ]);
    }
}
