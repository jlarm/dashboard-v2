<?php

declare(strict_types=1);

namespace App\Domain\Tenant\DealJackets\Actions;

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;

class SaveDealJacket
{
    /**
     * Persists a deal jacket within a group. Caller passes the (possibly null)
     * existing DealJacket; if null we create a fresh one. Calculates totals
     * + percentage from the supplied responses.
     *
     * @param  array{
     *   audit_date: string,
     *   date_of_deal_jacket: string,
     *   customer_name: string,
     *   customer_deal_number: string,
     *   user_id: ?int,
     *   mileage: string,
     *   purchase_type: string,
     *   vehicle_type: string,
     *   responses: array<int, array{statement: string, answer: ?string, high_risk: bool, comment: ?string}>,
     *   question_weights: array<int, int>,
     * }  $data
     */
    public function handle(DealJacketGroup $group, ?DealJacket $jacket, array $data): DealJacket
    {
        $totals = $this->computeTotals($data['responses'], $data['question_weights']);

        $attributes = [
            'audit_date' => $data['audit_date'],
            'date_of_deal_jacket' => $data['date_of_deal_jacket'],
            'customer_name' => $data['customer_name'],
            'customer_deal_number' => $data['customer_deal_number'],
            'user_id' => $data['user_id'],
            'mileage' => $data['mileage'],
            'purchase_type' => $data['purchase_type'],
            'vehicle_type' => $data['vehicle_type'],
            'responses' => $data['responses'],
            ...$totals,
        ];

        if ($jacket instanceof DealJacket) {
            $jacket->update($attributes);

            return $jacket;
        }

        return $group->dealJackets()->create($attributes);
    }

    /**
     * @param  array<int, array{answer: ?string, high_risk: bool}>  $responses
     * @param  array<int, int>  $weights
     * @return array{total_passed: int, total_failed: int, total_high_risk: int, percentage: int}
     */
    private function computeTotals(array $responses, array $weights): array
    {
        $passed = 0;
        $failed = 0;
        $highRisk = 0;
        $totalWeight = 0;
        $earnedWeight = 0;

        foreach ($responses as $index => $row) {
            $answer = $row['answer'] ?? null;

            if ($answer === 'yes') {
                $passed++;
            } elseif ($answer === 'no') {
                $failed++;
            }
            if (($row['high_risk'] ?? false) === true) {
                $highRisk++;
            }

            if ($answer === 'na' || $answer === null) {
                continue;
            }

            $weight = $weights[$index] ?? 1;
            $totalWeight += $weight;

            if ($answer === 'yes') {
                $earnedWeight += $weight;
            }
            if (($row['high_risk'] ?? false) === true) {
                $earnedWeight -= $weight * 0.5;
            }
        }

        return [
            'total_passed' => $passed,
            'total_failed' => $failed,
            'total_high_risk' => $highRisk,
            'percentage' => $totalWeight > 0 ? (int) round(($earnedWeight / $totalWeight) * 100) : 0,
        ];
    }
}
