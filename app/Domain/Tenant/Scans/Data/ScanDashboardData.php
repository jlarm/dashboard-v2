<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

final readonly class ScanDashboardData
{
    public function __construct(
        public bool $isConfigured,
        public bool $hasShortName,
        public bool $hasScanData,
        public bool $hasExternalScans,
        public bool $hasInternalScans,
        public RiskGradeData $overallRisk,
        public RiskGradeData $vulnerabilityRisk,
        public IssueCountsData $issueCounts,
        public ?string $lastScanDate,
    ) {}

    /**
     * @return array{
     *   is_configured: bool,
     *   has_short_name: bool,
     *   has_scan_data: bool,
     *   has_external_scans: bool,
     *   has_internal_scans: bool,
     *   overall_risk: array{current: ?string, previous: ?string, trend: string},
     *   vulnerability_risk: array{current: ?string, previous: ?string, trend: string},
     *   issue_counts: array{total: ?int, critical: ?int, high: ?int, medium: ?int, low: ?int, grade: ?string},
     *   last_scan_date: ?string,
     * }
     */
    public function toArray(): array
    {
        return [
            'is_configured' => $this->isConfigured,
            'has_short_name' => $this->hasShortName,
            'has_scan_data' => $this->hasScanData,
            'has_external_scans' => $this->hasExternalScans,
            'has_internal_scans' => $this->hasInternalScans,
            'overall_risk' => $this->overallRisk->toArray(),
            'vulnerability_risk' => $this->vulnerabilityRisk->toArray(),
            'issue_counts' => $this->issueCounts->toArray(),
            'last_scan_date' => $this->lastScanDate,
        ];
    }
}
