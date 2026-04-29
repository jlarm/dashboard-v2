<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Domain\Tenant\Scans\Data\ScanReportData;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\Support\Facades\Cache;

class GetCachedScanReport
{
    public function __construct(private readonly CyrismaService $cyrisma) {}

    public function handle(Store $store, string $type): ?ScanReportData
    {
        $service = $this->cyrisma->forStore($store);

        if (! $service->isConfigured() || ! $service->hasShortName()) {
            return null;
        }

        $cacheKey = sprintf('cyrisma_report_pdf_v2_%d_%s', $store->id, $type);
        $pdfBinary = Cache::get($cacheKey);

        if ($pdfBinary === null) {
            return null;
        }

        $fileName = sprintf(
            '%s-%s-%s-report.pdf',
            str_replace(' ', '-', (string) $store->name),
            $type,
            now()->format('Ymd-His'),
        );

        return new ScanReportData(
            type: $type,
            fileName: $fileName,
            pdfBinary: (string) $pdfBinary,
        );
    }
}
