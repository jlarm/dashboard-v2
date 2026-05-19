<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Scans\Actions\QueueScanReport;
use App\Domain\Tenant\Scans\Actions\RefreshScanCache;
use App\Domain\Tenant\Scans\Queries\GetCveList;
use App\Domain\Tenant\Scans\Queries\GetCveRiskChart;
use App\Domain\Tenant\Scans\Queries\GetExternalFindingDetails;
use App\Domain\Tenant\Scans\Queries\GetExternalIpExposure;
use App\Domain\Tenant\Scans\Queries\GetOpenPortsList;
use App\Domain\Tenant\Scans\Queries\GetScanDashboard;
use App\Domain\Tenant\Scans\Queries\GetScanOverview;
use App\Domain\Tenant\Scans\Queries\ResolveScannableStores;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Scans\QueueScanReportRequest;
use App\Jobs\Scans\GenerateCyrismaReportJob;
use App\Models\Dealer\Store;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use RuntimeException;
use Throwable;

class ScansController extends Controller
{
    public function index(
        Request $request,
        ResolveScannableStores $resolveScannableStores,
        GetScanOverview $getScanOverview,
        GetScanDashboard $getScanDashboard,
        GetCveList $getCveList,
        GetOpenPortsList $getOpenPortsList,
        GetCveRiskChart $getCveRiskChart,
        GetExternalIpExposure $getExternalIpExposure,
    ): InertiaResponse {
        $scopedStoreIds = $resolveScannableStores->handle($request->user());

        if ($scopedStoreIds->count() !== 1) {
            return Inertia::render('tenant/scans/Index', [
                'mode' => 'overview',
                'overview' => $getScanOverview->handle($scopedStoreIds),
                'dashboard' => null,
                'store' => null,
                'error' => null,
            ]);
        }

        $store = Store::query()->find($scopedStoreIds->first());

        if (! $store instanceof Store) {
            return Inertia::render('tenant/scans/Index', [
                'mode' => 'error',
                'overview' => [],
                'dashboard' => null,
                'store' => null,
                'error' => 'Unable to load store information. Please try again later.',
            ]);
        }

        $cveAssetType = $this->resolveAssetType($request, GetCveList::ALLOWED_ASSET_TYPES, 'cve_asset_type');
        $portAssetType = $this->resolveAssetType($request, GetOpenPortsList::ALLOWED_ASSET_TYPES, 'port_asset_type');

        return Inertia::render('tenant/scans/Index', [
            'mode' => 'dashboard',
            'overview' => [],
            'store' => [
                'id' => $store->id,
                'name' => $store->name,
            ],
            'error' => null,
            'filters' => [
                'cve_asset_type' => $cveAssetType,
                'port_asset_type' => $portAssetType,
            ],
            'dashboard' => Inertia::defer(static function () use ($store, $getScanDashboard): array {
                try {
                    return [
                        'data' => $getScanDashboard->handle($store)->toArray(),
                        'error' => null,
                    ];
                } catch (Exception $e) {
                    Log::error('Failed to load Cyrisma scan data', [
                        'store_id' => $store->id,
                        'message' => $e->getMessage(),
                    ]);

                    return [
                        'data' => null,
                        'error' => 'Unable to connect to the scanning service. Please try again later.',
                    ];
                }
            }),
            'cveList' => Inertia::defer(static function () use ($store, $cveAssetType, $getCveList): array {
                try {
                    return $getCveList->handle($store, $cveAssetType);
                } catch (Exception $e) {
                    Log::error('Failed to load CVE list', ['store_id' => $store->id, 'message' => $e->getMessage()]);

                    return [];
                }
            }, 'cve-list'),
            'openPorts' => Inertia::defer(static function () use ($store, $portAssetType, $getOpenPortsList): array {
                try {
                    return $getOpenPortsList->handle($store, $portAssetType);
                } catch (Exception $e) {
                    Log::error('Failed to load open ports', ['store_id' => $store->id, 'message' => $e->getMessage()]);

                    return [];
                }
            }, 'open-ports'),
            'cveChart' => Inertia::defer(static function () use ($store, $getCveRiskChart): array {
                try {
                    return $getCveRiskChart->handle($store)->toArray();
                } catch (Exception $e) {
                    Log::error('Failed to load CVE chart', ['store_id' => $store->id, 'message' => $e->getMessage()]);

                    return ['categories' => [], 'series' => ['critical' => [], 'high' => [], 'medium' => [], 'low' => []]];
                }
            }, 'cve-chart'),
            'externalIp' => Inertia::defer(static function () use ($store, $getExternalIpExposure): array {
                try {
                    return $getExternalIpExposure->handle($store)->toArray();
                } catch (Exception $e) {
                    Log::error('Failed to load external IP exposure', ['store_id' => $store->id, 'message' => $e->getMessage()]);

                    return ['last_scan_finished' => null, 'assets' => []];
                }
            }, 'external-ip'),
        ]);
    }

    public function queueReport(
        QueueScanReportRequest $request,
        ResolveScannableStores $resolveScannableStores,
        QueueScanReport $queueScanReport,
    ): JsonResponse {
        $store = $this->resolveSingleStore($request, $resolveScannableStores);
        $user = $request->user();

        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $type = $request->reportType();

        try {
            $status = $queueScanReport->handle($store, $user, $type);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => 'error',
                'message' => 'We could not queue the '.$type.' report. Please try again.',
            ], 500);
        }

        return response()->json(match ($status) {
            QueueScanReport::STATUS_ALREADY_RUNNING => [
                'status' => 'already-running',
                'message' => 'Your '.ucfirst($type).' report is already being generated. You\'ll receive a notification when it\'s ready.',
            ],
            default => [
                'status' => 'queued',
                'message' => ucfirst($type).' report queued — you\'ll get a notification when it\'s ready to download.',
            ],
        });
    }

    public function reportStatus(
        Request $request,
        ResolveScannableStores $resolveScannableStores,
        string $type,
    ): JsonResponse {
        if (! in_array($type, QueueScanReport::ALLOWED_TYPES, true)) {
            return response()->json(['status' => 'invalid'], 422);
        }

        $store = $this->resolveSingleStore($request, $resolveScannableStores);

        $pdfCacheKey = sprintf('cyrisma_report_pdf_v2_%d_%s', $store->id, $type);

        if (Cache::has($pdfCacheKey)) {
            return response()->json([
                'status' => 'ready',
                'url' => route('dealer.scan.report', ['type' => $type]),
            ]);
        }

        $lockKey = 'laravel_unique_job:'.GenerateCyrismaReportJob::class.'-'.$store->id.'-'.$type;

        if (Cache::has($lockKey)) {
            return response()->json(['status' => 'pending']);
        }

        return response()->json(['status' => 'not-queued']);
    }

    public function refreshCache(
        Request $request,
        ResolveScannableStores $resolveScannableStores,
        RefreshScanCache $refreshScanCache,
    ): RedirectResponse {
        $store = $this->resolveSingleStore($request, $resolveScannableStores);

        $refreshScanCache->handle($store);

        return back()->with('success', 'Scan cache refreshed.');
    }

    public function externalFinding(
        Request $request,
        ResolveScannableStores $resolveScannableStores,
        GetExternalFindingDetails $getExternalFindingDetails,
    ): JsonResponse {
        $assetIp = (string) $request->query('asset_ip', '');
        $findingName = (string) $request->query('finding_name', '');

        if ($assetIp === '' || $findingName === '') {
            return new JsonResponse(['finding' => null], 422);
        }

        $scopedStoreIds = $resolveScannableStores->handle($request->user());
        $store = $scopedStoreIds->count() === 1 ? Store::query()->find($scopedStoreIds->first()) : null;

        if (! $store instanceof Store) {
            return new JsonResponse(['finding' => null], 404);
        }

        try {
            $finding = $getExternalFindingDetails->handle($store, $assetIp, $findingName);
        } catch (Exception $e) {
            Log::error('Failed to load external finding details', [
                'store_id' => $store->id,
                'asset_ip' => $assetIp,
                'finding_name' => $findingName,
                'message' => $e->getMessage(),
            ]);

            return new JsonResponse(['finding' => null], 500);
        }

        return new JsonResponse(['finding' => $finding?->toArray()]);
    }

    private function resolveSingleStore(Request $request, ResolveScannableStores $resolveScannableStores): Store
    {
        $scopedStoreIds = $resolveScannableStores->handle($request->user());

        abort_unless($scopedStoreIds->count() === 1, 404);

        $store = Store::query()->find($scopedStoreIds->first());

        abort_unless($store instanceof Store, 404);

        return $store;
    }

    /**
     * @param  list<string>  $allowed
     */
    private function resolveAssetType(Request $request, array $allowed, string $key): ?string
    {
        $value = $request->query($key);

        if (! is_string($value) || $value === '') {
            return null;
        }

        return in_array($value, $allowed, true) ? $value : null;
    }
}
