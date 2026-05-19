<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Domain\Tenant\Scans\Data\ArchivedScanReportData;
use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;

class GetArchivedScanReports
{
    public const string SCAN_TYPE_EXTERNAL = 'external';
    public const string SCAN_TYPE_INTERNAL = 'internal';

    /**
     * Group archived scan reports for a store by created-at date,
     * then by report type (executive/technical) — matching the
     * shape the original Livewire view expected.
     *
     * @return array<string, array<string, array{id: int, type: string, url: string, created_at_formatted: string}>>
     */
    public function handle(Store $store, string $scanType, bool $multipleStoresExist): array
    {
        $query = ScanReport::query()
            ->where('scan_type', $scanType)
            ->latest();

        if ($multipleStoresExist) {
            $query->where('store_id', $store->id);
        }

        return $query->get()
            ->groupBy(static fn (ScanReport $report): string => $report->created_at?->format('F d, Y') ?? 'Unknown')
            ->map(static fn (\Illuminate\Support\Collection $reports): array => $reports
                ->groupBy('type')
                ->map(static fn (\Illuminate\Support\Collection $byType): array => ArchivedScanReportData::fromModel($byType->first())->toArray())
                ->all()
            )
            ->all();
    }
}
