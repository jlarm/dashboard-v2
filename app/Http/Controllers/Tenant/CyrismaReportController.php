<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class CyrismaReportController
{
    private const REPORT_TYPES = ['executive', 'technical'];

    public function download(string $type): Response|StreamedResponse
    {
        if (! in_array($type, self::REPORT_TYPES, true)) {
            abort(404);
        }

        $storeContext = app('currentStore');
        $store = $storeContext instanceof Store ? $storeContext : Store::find((int) $storeContext);

        if (! $store) {
            abort(404);
        }

        $cyrisma = app(CyrismaService::class)->forStore($store);

        if (! $cyrisma->isConfigured() || ! $cyrisma->hasShortName()) {
            abort(404);
        }

        $cacheKey = sprintf('cyrisma_report_pdf_v2_%d_%s', $store->id, $type);
        $refresh = request()->boolean('refresh');

        if ($refresh) {
            Cache::forget($cacheKey);
        }

        try {
            $pdfBinary = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($type, $cyrisma, $store) {
                $data = $this->buildReportData($cyrisma, $store, $type);
                $view = $type === 'executive'
                    ? 'tenant.scans.reports.executive'
                    : 'tenant.scans.reports.technical';

                return Pdf::loadView($view, $data)
                    ->setPaper('letter')
                    ->output();
            });
        } catch (Throwable $e) {
            Log::error('PDF generation failed', [
                'type' => $type,
                'store_id' => $store->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile().':'.$e->getLine(),
            ]);

            abort(500, 'PDF generation failed: '.$e->getMessage());
        }

        $fileName = sprintf(
            '%s-%s-%s-report.pdf',
            str_replace(' ', '-', $store->name),
            $type,
            now()->format('Ymd-His')
        );

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$fileName.'"',
        ];

        if ($refresh) {
            $headers['Cache-Control'] = 'no-store, no-cache, must-revalidate, max-age=0';
            $headers['Pragma'] = 'no-cache';
        } else {
            $headers['Cache-Control'] = 'private, max-age=1800';
        }

        return response()->stream(function () use ($pdfBinary) {
            echo $pdfBinary;
        }, 200, $headers);
    }

    private function buildReportData(CyrismaService $cyrisma, Store $store, string $type): array
    {
        $overall = $cyrisma->getOverallDashboard() ?? [];
        $vulnerabilityScans = $cyrisma->getVulnerabilityScans() ?? [];
        $scanList = $vulnerabilityScans['vulnerability_scans'] ?? [];
        $issueCounts = $scanList[0] ?? [];

        $lastScanDate = null;
        if (! empty($scanList)) {
            $latestScan = collect($scanList)->sortByDesc('scan_finished')->first();
            if (! empty($latestScan['scan_finished'])) {
                $lastScanDate = Carbon::parse($latestScan['scan_finished'])->format('M j, Y');
            }
        }

        $externalScanData = $cyrisma->getExternalIpScanData();
        $externalAssets = is_array($externalScanData) ? ($externalScanData['assets'] ?? []) : [];
        $externalScanInfo = is_array($externalScanData) ? ($externalScanData['scan_info'] ?? []) : [];
        $externalAssetCount = count($externalAssets);

        $internalVulnerabilities = $cyrisma->getVulnerabilitiesByAssetType('internal');
        $internalVulnCount = count($internalVulnerabilities['vulnerabilities'] ?? []);

        $cveDetails = $cyrisma->getCveDetails() ?? [];
        $cveItems = array_slice($cveDetails['cve_items'] ?? [], 1);
        $openPorts = $cyrisma->getOpenPortsByAssetType();

        $data = [
            'storeName' => $store->name,
            'generatedAt' => now()->format('M j, Y g:i A'),
            'lastScanDate' => $lastScanDate,
            'overall' => $overall,
            'issueCounts' => $issueCounts,
            'externalAssetCount' => $externalAssetCount,
            'internalVulnCount' => $internalVulnCount,
            'externalAssets' => $externalAssets,
            'externalScanInfo' => $externalScanInfo,
            'cveItems' => $cveItems,
            'openPorts' => $openPorts,
        ];

        return $data;
    }
}
