<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Domain\Tenant\Scans\Data\ScanReportStatsData;
use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;

class GetScanReportStats
{
    /**
     * Latest grade + exploit/CVE breakdown for a store's most recent
     * archived scan of the given type. Mirrors the External/InternalStats
     * Livewire components.
     */
    public function handle(Store $store, string $scanType): ScanReportStatsData
    {
        $report = ScanReport::query()
            ->where('store_id', $store->id)
            ->where('scan_type', $scanType)
            ->latest()
            ->first();

        return ScanReportStatsData::fromModel($report);
    }
}
