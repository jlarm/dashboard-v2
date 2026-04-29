<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

use App\Models\Dealer\ScanReport;

final readonly class ScanReportStatsData
{
    public function __construct(
        public ?string $grade,
        public ?int $exploitsHigh,
        public ?int $exploitsMedium,
        public ?int $exploitsLow,
        public ?int $cvesHigh,
        public ?int $cvesMedium,
        public ?int $cvesLow,
    ) {}

    public static function fromModel(?ScanReport $report): self
    {
        if (! $report instanceof ScanReport) {
            return new self(null, null, null, null, null, null, null);
        }

        return new self(
            grade: $report->grade !== null ? (string) $report->grade : null,
            exploitsHigh: self::nullableInt($report->exploits_high),
            exploitsMedium: self::nullableInt($report->exploits_medium),
            exploitsLow: self::nullableInt($report->exploits_low),
            cvesHigh: self::nullableInt($report->cves_high),
            cvesMedium: self::nullableInt($report->cves_medium),
            cvesLow: self::nullableInt($report->cves_low),
        );
    }

    /**
     * @return array{grade: ?string, exploits: array{high: ?int, medium: ?int, low: ?int}, cves: array{high: ?int, medium: ?int, low: ?int}}
     */
    public function toArray(): array
    {
        return [
            'grade' => $this->grade,
            'exploits' => [
                'high' => $this->exploitsHigh,
                'medium' => $this->exploitsMedium,
                'low' => $this->exploitsLow,
            ],
            'cves' => [
                'high' => $this->cvesHigh,
                'medium' => $this->cvesMedium,
                'low' => $this->cvesLow,
            ],
        ];
    }

    private static function nullableInt(mixed $value): ?int
    {
        return is_numeric($value) ? (int) $value : null;
    }
}
