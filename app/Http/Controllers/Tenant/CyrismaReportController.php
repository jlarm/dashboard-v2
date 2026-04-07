<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CyrismaReportController
{
    private const REPORT_TYPES = ['executive', 'technical'];

    public function download(): Response|StreamedResponse
    {
        $type = (string) request()->route('type');

        abort_unless(in_array($type, self::REPORT_TYPES, true), 404);

        $store = $this->resolveStore();

        abort_unless($store instanceof Store, 404);

        $cyrisma = app(CyrismaService::class)->forStore($store);

        abort_if(! $cyrisma->isConfigured() || ! $cyrisma->hasShortName(), 404);

        $cacheKey = sprintf('cyrisma_report_pdf_v2_%d_%s', $store->id, $type);

        $pdfBinary = Cache::get($cacheKey);

        abort_unless($pdfBinary !== null, 404, 'Report not yet generated. Please request it from the scan details page.');

        $fileName = sprintf(
            '%s-%s-%s-report.pdf',
            str_replace(' ', '-', $store->name),
            $type,
            now()->format('Ymd-His')
        );

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

        $currentStore = app()->bound('currentStore') ? app('currentStore') : null;

        if ($currentStore instanceof Store) {
            return $currentStore;
        }

        if (is_numeric($currentStore)) {
            $store = Store::query()->find((int) $currentStore);

            if ($store instanceof Store) {
                return $store;
            }
        }

        $scopedStoreIds = app()->bound('scopedStoreIds') ? app('scopedStoreIds') : collect();
        $firstScopedStoreId = $scopedStoreIds->first();

        if (is_numeric($firstScopedStoreId)) {
            return Store::query()->find((int) $firstScopedStoreId);
        }

        return Store::query()->orderBy('id')->first();
    }
}
