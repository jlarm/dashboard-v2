<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Scans\Queries\GetCveList;
use App\Domain\Tenant\Scans\Queries\GetCveRiskChart;
use App\Domain\Tenant\Scans\Queries\GetOpenPortsList;
use App\Domain\Tenant\Scans\Queries\GetScanDashboard;
use App\Domain\Tenant\Scans\Queries\GetScanOverview;
use App\Domain\Tenant\Scans\Queries\ResolveScannableStores;
use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

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
        ]);
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
