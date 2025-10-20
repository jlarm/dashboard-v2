<?php

namespace Database\Factories\Tenant;

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\DealJacketQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DealJacketFactory extends Factory
{
    protected $model = DealJacket::class;

    public function definition(): array
    {
        $responses = $this->generateResponses();
        $totalPassed = collect($responses)->where('answer', 'yes')->count();
        $totalFailed = collect($responses)->where('answer', 'no')->count();
        $totalHighRisk = collect($responses)->where('high_risk', true)->count();
        $total = $totalPassed + $totalFailed;
        $percentage = $total > 0 ? round(($totalPassed / $total) * 100) : 0;

        // Use existing user or create one if none exist
        $user = User::query()->inRandomOrder()->first();
        if (! $user) {
            $user = User::factory()->create();
        }

        return [
            'uuid' => Str::uuid()->toString(),
            'deal_jacket_group_id' => DealJacketGroup::factory(),
            'audit_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'date_of_deal_jacket' => $this->faker->dateTimeBetween('-60 days', '-1 days'),
            'customer_name' => $this->faker->name(),
            'customer_deal_number' => $this->faker->unique()->numerify('DEAL-#####'),
            'user_id' => $user->id,
            'mileage' => $this->faker->numberBetween(0, 150000),
            'purchase_type' => $this->faker->randomElement(['cash', 'finance', 'lease']),
            'vehicle_type' => $this->faker->randomElement(['new', 'used']),
            'responses' => $responses,
            'total_passed' => $totalPassed,
            'total_failed' => $totalFailed,
            'total_high_risk' => $totalHighRisk,
            'percentage' => $percentage,
        ];
    }

    private function generateResponses(): array
    {
        $questions = tenancy()->central(fn () => DealJacketQuestion::query()->get());

        if ($questions->isEmpty()) {
            return [];
        }

        $responses = [];

        foreach ($questions as $question) {
            $answer = $this->faker->randomElement(['yes', 'yes', 'yes', 'no']);
            $hasComment = $answer === 'no' && $this->faker->boolean(30);

            $responses[$question->id] = [
                'statement' => $question->statement,
                'answer' => $answer,
                'high_risk' => $answer === 'no' && $this->faker->boolean(20),
                'comment' => $hasComment ? $this->faker->sentence() : null,
            ];
        }

        return $responses;
    }
}
