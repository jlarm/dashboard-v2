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
        $latestScan = $scans[0] ?? null;

        $overallDashboard = $service->getOverallDashboard() ?? [];

        return new ScanDashboardData(
            isConfigured: true,
            hasShortName: true,
            hasScanData: $scans !== [],
            hasExternalScans: $service->getExternalIpScanData() !== null,
            hasInternalScans: $service->hasInternalScans(),
            overallRisk: RiskGradeData::fromOverallDashboard($overallDashboard, 'or'),
            vulnerabilityRisk: RiskGradeData::fromOverallDashboard($overallDashboard, 'vn'),
            issueCounts: is_array($latestScan) ? IssueCountsData::fromScan($latestScan) : IssueCountsData::empty(),
            lastScanDate: $this->resolveLastScanDate($scans),
        );
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
