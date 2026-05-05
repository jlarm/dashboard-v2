<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

final readonly class CriticalVulnerabilitiesData
{
    public function __construct(
        public int $critical_count,
        public ?int $days_since_last_scan,
    ) {}

    /**
     * @return array{critical_count:int, days_since_last_scan:?int}
     */
    public function toArray(): array
    {
        return [
            'critical_count' => $this->critical_count,
            'days_since_last_scan' => $this->days_since_last_scan,
        ];
    }
}
