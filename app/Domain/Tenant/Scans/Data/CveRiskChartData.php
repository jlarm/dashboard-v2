<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

final readonly class CveRiskChartData
{
    /**
     * @param  list<string>  $categories
     * @param  list<int>  $critical
     * @param  list<int>  $high
     * @param  list<int>  $medium
     * @param  list<int>  $low
     */
    public function __construct(
        public array $categories,
        public array $critical,
        public array $high,
        public array $medium,
        public array $low,
    ) {}

    public static function empty(): self
    {
        return new self([], [], [], [], []);
    }

    /**
     * @return array{categories: list<string>, series: array{critical: list<int>, high: list<int>, medium: list<int>, low: list<int>}}
     */
    public function toArray(): array
    {
        return [
            'categories' => $this->categories,
            'series' => [
                'critical' => $this->critical,
                'high' => $this->high,
                'medium' => $this->medium,
                'low' => $this->low,
            ],
        ];
    }
}
