<?php

declare(strict_types=1);

namespace App\Domain\Tenant\DealJackets\Queries;

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;

class LoadDealJacketGroup
{
    /**
     * @return array{
     *   id: int,
     *   uuid: string,
     *   completed: bool,
     *   created_at: ?string,
     *   store_name: string,
     *   deal_jackets: array<int, array{id: int, uuid: string, audit_date: string, customer_name: ?string, customer_deal_number: ?string, finance_manager_name: ?string, total_passed: int, total_failed: int, total_high_risk: int, percentage: int}>,
     *   total_passed: int,
     *   total_failed: int,
     *   total_high_risk: int,
     *   average_percentage: ?float,
     * }
     */
    public function handle(DealJacketGroup $group): array
    {
        $group->loadMissing(['store', 'dealJackets.user']);
        $group->loadAggregate('dealJackets as average_percentage', 'percentage', 'avg');

        $jackets = $group->dealJackets->map(static fn (DealJacket $jacket): array => [
            'id' => (int) $jacket->id,
            'uuid' => (string) $jacket->uuid,
            'audit_date' => $jacket->audit_date?->toDateString() ?? '',
            'customer_name' => $jacket->customer_name,
            'customer_deal_number' => $jacket->customer_deal_number,
            'finance_manager_name' => $jacket->user?->name,
            'total_passed' => (int) $jacket->total_passed,
            'total_failed' => (int) $jacket->total_failed,
            'total_high_risk' => (int) $jacket->total_high_risk,
            'percentage' => (int) $jacket->percentage,
        ])->all();

        return [
            'id' => (int) $group->id,
            'uuid' => (string) $group->uuid,
            'completed' => (bool) $group->completed,
            'created_at' => $group->created_at?->toIso8601String(),
            'store_name' => (string) ($group->store->name ?? ''),
            'deal_jackets' => $jackets,
            'total_passed' => array_sum(array_column($jackets, 'total_passed')),
            'total_failed' => array_sum(array_column($jackets, 'total_failed')),
            'total_high_risk' => array_sum(array_column($jackets, 'total_high_risk')),
            'average_percentage' => $group->average_percentage !== null ? (float) $group->average_percentage : null,
        ];
    }
}
