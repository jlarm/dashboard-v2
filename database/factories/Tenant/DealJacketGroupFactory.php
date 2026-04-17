<?php

declare(strict_types=1);

namespace Database\Factories\Tenant;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Override;

class DealJacketGroupFactory extends Factory
{
    #[Override]
    protected $model = DealJacketGroup::class;

    public function definition(): array
    {
        $store = Store::query()->inRandomOrder()->first();
        if (! $store) {
            $store = Store::query()->create([
                'name' => $this->faker->company(),
                'slug' => Str::slug($this->faker->company()),
            ]);
        }

        return [
            'uuid' => (string) Str::uuid(),
            'store_id' => $store->id,
            'completed' => false,
        ];
    }
}
