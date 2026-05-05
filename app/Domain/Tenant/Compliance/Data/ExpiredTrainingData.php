<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

final readonly class ExpiredTrainingData
{
    public function __construct(
        public int $count,
        public int $expiring_soon_count,
        public ?int $previous_count,
        public ?float $delta_pct,
    ) {}

    /**
     * @return array{count:int, expiring_soon_count:int, previous_count:?int, delta_pct:?float}
     */
    public function toArray(): array
    {
        return [
            'count' => $this->count,
            'expiring_soon_count' => $this->expiring_soon_count,
            'previous_count' => $this->previous_count,
            'delta_pct' => $this->delta_pct,
        ];
    }
}
