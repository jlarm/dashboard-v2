<?php

declare(strict_types=1);

namespace App\Domain\Tenant\DealJackets\Data;

use App\Models\Dealer\Audit\DealJacketGroup;

class DealJacketGroupListItem
{
    public function __construct(
        public readonly int $id,
        public readonly string $uuid,
        public readonly string $createdAt,
        public readonly bool $completed,
        public readonly int $dealJacketsCount,
        public readonly int $totalPassed,
        public readonly int $totalFailed,
        public readonly int $totalHighRisk,
        public readonly ?float $averagePercentage,
    ) {}

    public static function fromModel(DealJacketGroup $group): self
    {
        return new self(
            id: (int) $group->id,
            uuid: (string) $group->uuid,
            createdAt: $group->created_at?->toIso8601String() ?? '',
            completed: (bool) $group->completed,
            dealJacketsCount: (int) ($group->deal_jackets_count ?? 0),
            totalPassed: (int) ($group->total_passed ?? 0),
            totalFailed: (int) ($group->total_failed ?? 0),
            totalHighRisk: (int) ($group->total_high_risk ?? 0),
            averagePercentage: $group->average_percentage !== null ? (float) $group->average_percentage : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'created_at' => $this->createdAt,
            'completed' => $this->completed,
            'deal_jackets_count' => $this->dealJacketsCount,
            'total_passed' => $this->totalPassed,
            'total_failed' => $this->totalFailed,
            'total_high_risk' => $this->totalHighRisk,
            'average_percentage' => $this->averagePercentage,
        ];
    }
}
