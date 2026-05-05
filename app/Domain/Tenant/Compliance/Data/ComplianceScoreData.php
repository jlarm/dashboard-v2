<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

use Carbon\CarbonImmutable;

class ComplianceScoreData
{
    /**
     * @param  list<PillarScoreData>  $pillars
     */
    public function __construct(
        public readonly int $storeId,
        public readonly float $score,
        public readonly array $pillars,
        public readonly CarbonImmutable $computedAt,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'store_id' => $this->storeId,
            'score' => round($this->score, 1),
            'pillars' => array_map(static fn (PillarScoreData $pillar): array => $pillar->toArray(), $this->pillars),
            'computed_at' => $this->computedAt->toIso8601String(),
        ];
    }
}
