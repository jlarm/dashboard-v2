<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

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

        return Inertia::render('tenant/scans/Index', [
            'mode' => 'dashboard',
            'overview' => [],
            'store' => [
                'id' => $store->id,
                'name' => $store->name,
            ],
            'error' => null,
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
        ]);
    }
}
