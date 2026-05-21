<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Dealer\Store;
use App\Models\FitTestDoc;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;

/**
 * @extends Factory<FitTestDoc>
 */
class FitTestDocFactory extends Factory
{
    #[Override]
    protected $model = FitTestDoc::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'store_id' => Store::query()->value('id'),
            'user_id' => User::query()->value('id'),
            'employee_name' => $this->faker->name(),
            'date' => $this->faker->date(),
            'file_path' => 'fits/'.$this->faker->uuid().'.pdf',
        ];
    }
}
