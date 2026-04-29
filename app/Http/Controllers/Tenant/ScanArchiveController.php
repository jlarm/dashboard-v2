<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Scans\Actions\UploadScanReport;
use App\Domain\Tenant\Scans\Queries\GetArchivedScanReports;
use App\Domain\Tenant\Scans\Queries\GetScanReportStats;
use App\Domain\Tenant\Scans\Queries\ResolveScannableStores;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Scans\UploadScanReportRequest;
use App\Models\Dealer\Store;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use function Sentry\captureException;

class ScanArchiveController extends Controller
{
    public function index(
        Request $request,
        ResolveScannableStores $resolveScannableStores,
        GetArchivedScanReports $getArchivedScanReports,
        GetScanReportStats $getScanReportStats,
    ): InertiaResponse {
        $store = $this->resolveCurrentStore($request, $resolveScannableStores);

        $multipleStoresExist = (bool) (app()->bound('multipleStoresExist') ? resolve('multipleStoresExist') : false);

        return Inertia::render('tenant/scans/Archive', [
            'store' => [
                'id' => $store->id,
                'name' => $store->name,
            ],
            'canUpload' => $request->user()?->can('create-dealerships') === true,
            'externalReports' => $getArchivedScanReports->handle($store, GetArchivedScanReports::SCAN_TYPE_EXTERNAL, $multipleStoresExist),
            'externalStats' => $getScanReportStats->handle($store, GetArchivedScanReports::SCAN_TYPE_EXTERNAL)->toArray(),
            'internalReports' => $getArchivedScanReports->handle($store, GetArchivedScanReports::SCAN_TYPE_INTERNAL, $multipleStoresExist),
            'internalStats' => $getScanReportStats->handle($store, GetArchivedScanReports::SCAN_TYPE_INTERNAL)->toArray(),
        ]);
    }

    public function upload(
        UploadScanReportRequest $request,
        UploadScanReport $uploadScanReport,
    ): RedirectResponse {
        try {
            $uploadScanReport->handle($request->toData());
        } catch (Exception $e) {
            Log::error('Scan report upload failed', ['message' => $e->getMessage()]);
            captureException($e);

            return back()->with('flash.error', 'Upload failed: '.$e->getMessage());
        }

        return back()->with('flash.success', 'Report uploaded successfully.');
    }

    private function resolveCurrentStore(Request $request, ResolveScannableStores $resolveScannableStores): Store
    {
        $scopedStoreIds = $resolveScannableStores->handle($request->user());

        $store = $scopedStoreIds->count() === 1
            ? Store::query()->find($scopedStoreIds->first())
            : null;

        abort_unless($store instanceof Store, 404);

        return $store;
    }
}
