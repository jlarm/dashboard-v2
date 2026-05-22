<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Domain\Tenant\Scans\Data\IssueCountsData;
use App\Domain\Tenant\Scans\Data\RiskGradeData;
use App\Domain\Tenant\Scans\Data\ScanDashboardData;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\Support\Facades\Date;

class GetScanDashboard
{
    public function __construct(private readonly CyrismaService $cyrisma) {}

    public function handle(Store $store): ScanDashboardData
    {
        $service = $this->cyrisma->forStore($store);

        $isConfigured = $service->isConfigured();
        $hasShortName = $service->hasShortName();

        if (! $isConfigured || ! $hasShortName) {
            return new ScanDashboardData(
                isConfigured: $isConfigured,
                hasShortName: $hasShortName,
                hasScanData: false,
                hasExternalScans: false,
                hasInternalScans: false,
                overallRisk: RiskGradeData::fromOverallDashboard([], 'or'),
                vulnerabilityRisk: RiskGradeData::fromOverallDashboard([], 'vn'),
                issueCounts: IssueCountsData::empty(),
                lastScanDate: null,
            );
        }

        $vulnerabilityScans = $service->getVulnerabilityScans();
        $scans = $vulnerabilityScans['vulnerability_scans'] ?? [];

        $scansByRecency = collect($scans)
            ->sortByDesc('scan_finished')
            ->values();

        $latestScan = $scansByRecency->first();
        $previousScan = $scansByRecency->get(1);

        $overallDashboard = $service->getOverallDashboard() ?? [];

        return new ScanDashboardData(
            isConfigured: true,
            hasShortName: true,
            hasScanData: $scans !== [],
            hasExternalScans: $service->getExternalIpScanData() !== null,
            hasInternalScans: $service->hasInternalScans(),
            overallRisk: $this->resolveGrade($overallDashboard, 'or', $latestScan, $previousScan),
            vulnerabilityRisk: $this->resolveGrade($overallDashboard, 'vn', $latestScan, $previousScan),
            issueCounts: is_array($latestScan) ? IssueCountsData::fromScan($latestScan) : IssueCountsData::empty(),
            lastScanDate: $this->resolveLastScanDate($scans),
        );
    }

    /**
     * Resolve a risk grade, preferring the Cyrisma overall-dashboard payload
     * and falling back to the latest vulnerability scan's letter grade when
     * the dashboard has no computed grade for this instance.
     *
     * @param  array<string, mixed>  $overallDashboard
     */
    private function resolveGrade(array $overallDashboard, string $prefix, mixed $latestScan, mixed $previousScan): RiskGradeData
    {
        $fromDashboard = RiskGradeData::fromOverallDashboard($overallDashboard, $prefix);

        if ($fromDashboard->current !== null) {
            return $fromDashboard;
        }

        return RiskGradeData::make(
            $this->scanGrade($latestScan),
            $this->scanGrade($previousScan),
        );
    }

    private function scanGrade(mixed $scan): ?string
    {
        if (! is_array($scan)) {
            return null;
        }

        $grade = $scan['grade_alpha'] ?? null;

        return is_string($grade) && $grade !== '' ? $grade : null;
    }

    /**
     * @param  array<int, array<string, mixed>>  $scans
     */
    private function resolveLastScanDate(array $scans): ?string
    {
        if ($scans === []) {
            return null;
        }

        $latest = collect($scans)
            ->sortByDesc('scan_finished')
            ->first();

        $finished = is_array($latest) ? ($latest['scan_finished'] ?? null) : null;

        if (! is_string($finished) || $finished === '') {
            return null;
        }

        return Date::parse($finished)->format('M j, Y');
    }
}
