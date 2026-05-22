<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Domain\Tenant\Scans\Data\StoreScanOverviewData;
use App\Models\Dealer\Store;
use Illuminate\Support\Collection;

class GetScanOverview
{
    /**
     * @param  Collection<int, int>  $storeIds
     * @return list<array{id: int, name: string, reports_count: int, latest_scan_report_date: ?string}>
     */
    public function handle(Collection $storeIds): array
    {
        if ($storeIds->isEmpty()) {
            return [];
        }

        return array_values(
            Store::query()
                ->whereIn('id', $storeIds)
                ->withCount('scanReports')
                ->with('latestScanReportDate')
                ->orderBy('name')
                ->get()
                ->map(static fn (Store $store): array => StoreScanOverviewData::fromStore($store)->toArray())
                ->all(),
        );
    }
}
