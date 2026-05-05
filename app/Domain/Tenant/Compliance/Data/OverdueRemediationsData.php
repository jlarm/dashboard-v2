<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

final readonly class OverdueRemediationsData
{
    public function __construct(
        public int $count,
        public int $high_severity_count,
        public ?int $previous_count,
        public ?float $delta_pct,
    ) {}

    /**
     * @return array{count:int, high_severity_count:int, previous_count:?int, delta_pct:?float}
     */
    public function toArray(): array
    {
        return [
            'count' => $this->count,
            'high_severity_count' => $this->high_severity_count,
            'previous_count' => $this->previous_count,
            'delta_pct' => $this->delta_pct,
        ];
    }
}
