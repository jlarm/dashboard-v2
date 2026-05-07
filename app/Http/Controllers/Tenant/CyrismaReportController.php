<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Scans\Data\ScanReportData;
use App\Domain\Tenant\Scans\Queries\GetCachedScanReport;
use App\Models\Dealer\Store;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CyrismaReportController
{
    private const array REPORT_TYPES = ['executive', 'technical'];

    public function download(GetCachedScanReport $getCachedScanReport): Response|StreamedResponse
    {
        $type = (string) request()->route('type');

        abort_unless(in_array($type, self::REPORT_TYPES, true), 404);

        $store = $this->resolveStore();

        abort_unless($store instanceof Store, 404);

        $report = $getCachedScanReport->handle($store, $type);

        abort_unless($report instanceof ScanReportData, 404, 'Report not yet generated. Please request it from the scan details page.');

        $pdfBinary = $report->pdfBinary;
        $fileName = $report->fileName;

        return response()->stream(function () use ($pdfBinary): void {
            echo $pdfBinary;
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$fileName.'"',
            'Cache-Control' => 'private, max-age=1800',
        ]);
    }

    private function resolveStore(): ?Store
    {
        $requestStore = request()->attributes->get('store');

        if ($requestStore instanceof Store) {
            return $requestStore;
        }

        $currentStore = app()->bound('currentStore') ? resolve('currentStore') : null;

        if ($currentStore instanceof Store) {
            return $currentStore;
        }

        if (is_numeric($currentStore)) {
            $store = Store::query()->find((int) $currentStore);

            if ($store instanceof Store) {
                return $store;
            }
        }

        $scopedStoreIds = app()->bound('scopedStoreIds') ? resolve('scopedStoreIds') : collect();
        $firstScopedStoreId = $scopedStoreIds->first();

        if (is_numeric($firstScopedStoreId)) {
            return Store::query()->find((int) $firstScopedStoreId);
        }

        return Store::query()->orderBy('id')->first();
    }
}
