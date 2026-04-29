<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Scans\Actions\UpdateScanSettings;
use App\Domain\Tenant\Scans\Queries\GetScanSettings;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Scans\UpdateScanSettingsRequest;
use App\Models\Dealer\Cyrisma;
use App\Models\Dealer\Store;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CyrismaController extends Controller
{
    public function settings(GetScanSettings $getScanSettings): InertiaResponse
    {
        $this->authorize('viewAny', Cyrisma::class);

        $store = $this->currentStore();
        abort_unless($store instanceof Store, 404);

        return Inertia::render('tenant/scans/Settings', [
            'settings' => $getScanSettings->handle($store)->toArray(),
        ]);
    }

    public function update(
        UpdateScanSettingsRequest $request,
        UpdateScanSettings $updateScanSettings,
    ): RedirectResponse {
        $updateScanSettings->handle($request->toData());

        return back()->with('flash.success', 'Instance configuration saved successfully.');
    }

    private function currentStore(): ?Store
    {
        if (app()->bound('currentStoreModel')) {
            $store = resolve('currentStoreModel');

            return $store instanceof Store ? $store : null;
        }

        if (app()->bound('currentStore')) {
            $storeId = resolve('currentStore');

            if (is_numeric($storeId)) {
                return Store::query()->find((int) $storeId);
            }
        }

        return null;
    }
}
