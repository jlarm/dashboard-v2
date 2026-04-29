<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Domain\Tenant\Scans\Data\CveRiskChartData;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;

class GetCveRiskChart
{
    public function __construct(private readonly CyrismaService $cyrisma) {}

    public function handle(Store $store): CveRiskChartData
    {
        $service = $this->cyrisma->forStore($store);
        $payload = $service->getVulnerabilityScans();
        $scans = $payload['vulnerability_scans'] ?? [];

        if ($scans === []) {
            return CveRiskChartData::empty();
        }

        $sortedScans = collect($scans)
            ->sortByDesc('scan_finished')
            ->take(5)
            ->sortBy('scan_finished')
            ->values();

        $categories = [];
        $critical = [];
        $high = [];
        $medium = [];
        $low = [];

        foreach ($sortedScans as $index => $scan) {
            $scanDate = $scan['scan_finished'] ?? $scan['scan_started'] ?? null;

            if (is_string($scanDate) && $scanDate !== '') {
                $categories[] = date('M Y', strtotime($scanDate));
            } else {
                $categories[] = (string) ($scan['scan_name'] ?? 'Scan '.($index + 1));
            }

            $critical[] = (int) ($scan['critical_vulnerabilities'] ?? 0);
            $high[] = (int) ($scan['high_vulnerabilities'] ?? 0);
            $medium[] = (int) ($scan['medium_vulnerabilities'] ?? 0);
            $low[] = (int) ($scan['low_vulnerabilities'] ?? 0);
        }

        return new CveRiskChartData(
            categories: $categories,
            critical: $critical,
            high: $high,
            medium: $medium,
            low: $low,
        );
    }
}
