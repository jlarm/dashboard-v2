<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

final readonly class RiskGradeData
{
    public function __construct(
        public ?string $current,
        public ?string $previous,
        public string $trend,
    ) {}

    /**
     * Build from a Cyrisma overall-dashboard payload using a key prefix
     * (e.g. "or" for overall risk, "vn" for vulnerabilities).
     *
     * @param  array<string, mixed>  $payload
     */
    public static function fromOverallDashboard(array $payload, string $prefix): self
    {
        $current = self::stringOrNull($payload, "current_{$prefix}_grade");
        $previous = self::stringOrNull($payload, "previous_{$prefix}_grade");

        return new self(
            current: $current,
            previous: $previous,
            trend: self::computeTrend($current, $previous),
        );
    }

    /**
     * @return array{current: ?string, previous: ?string, trend: string}
     */
    public function toArray(): array
    {
        return [
            'current' => $this->current,
            'previous' => $this->previous,
            'trend' => $this->trend,
        ];
    }

    private static function stringOrNull(array $payload, string $key): ?string
    {
        if (! isset($payload[$key]) || ! is_string($payload[$key]) || $payload[$key] === '') {
            return null;
        }

        return $payload[$key];
    }

    private static function computeTrend(?string $current, ?string $previous): string
    {
        $rank = [
            'A' => 1, 'A-' => 2,
            'B+' => 3, 'B' => 4, 'B-' => 5,
            'C+' => 6, 'C' => 7, 'C-' => 8,
            'D+' => 9, 'D' => 10, 'D-' => 11,
            'F' => 12,
        ];

        $currentRank = $rank[$current ?? ''] ?? 99;
        $previousRank = $rank[$previous ?? ''] ?? 99;

        if ($currentRank < $previousRank) {
            return 'improved';
        }

        if ($currentRank > $previousRank) {
            return 'declined';
        }

        return 'stable';
    }
}
