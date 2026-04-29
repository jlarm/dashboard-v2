<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

use App\Models\Dealer\Store;

final readonly class StoreScanOverviewData
{
    public function __construct(
        public int $id,
        public string $name,
        public int $reportsCount,
        public ?string $latestScanReportDate,
    ) {}

    public static function fromStore(Store $store): self
    {
        $latestDate = $store->latestScanReportDate?->created_at?->format('M j, Y');

        return new self(
            id: $store->id,
            name: (string) $store->name,
            reportsCount: (int) ($store->scan_reports_count ?? 0),
            latestScanReportDate: $latestDate,
        );
    }

    /**
     * @return array{id: int, name: string, reports_count: int, latest_scan_report_date: ?string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'reports_count' => $this->reportsCount,
            'latest_scan_report_date' => $this->latestScanReportDate,
        ];
    }
}
