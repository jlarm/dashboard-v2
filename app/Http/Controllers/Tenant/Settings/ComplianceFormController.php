<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Settings;

use App\Domain\Tenant\StoreSettings\Actions\UpdateComplianceSection;
use App\Domain\Tenant\StoreSettings\Actions\UpdateManagersSection;
use App\Domain\Tenant\StoreSettings\Queries\GetComplianceSection;
use App\Domain\Tenant\StoreSettings\Queries\GetManagersSection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Settings\UpdateComplianceFormRequest;
use App\Models\Dealer\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

/**
 * Public, signed-URL compliance form a dealership completes once. Replaces the
 * former FrontEndComplianceForm Livewire component.
 */
class ComplianceFormController extends Controller
{
    public function show(
        Request $request,
        GetComplianceSection $getComplianceSection,
        GetManagersSection $getManagersSection,
    ): InertiaResponse {
        $store = $this->resolveStore($request);

        return Inertia::render('tenant/settings/ComplianceForm', [
            'store' => [
                'id' => $store->id,
                'name' => $store->name,
            ],
            'managers' => $getManagersSection->handle($store)->toArray(),
            'compliance' => $getComplianceSection->handle($store)->toArray(),
            'userSubmitted' => $this->isSubmitted($store),
            'submitUrl' => $request->fullUrl(),
        ]);
    }

    public function update(
        UpdateComplianceFormRequest $request,
        UpdateComplianceSection $updateComplianceSection,
        UpdateManagersSection $updateManagersSection,
    ): RedirectResponse {
        $store = $this->resolveStore($request);

        if (! $this->isSubmitted($store)) {
            $updateManagersSection->handle($store, $request->toManagersData());
            $updateComplianceSection->handle($store, $request->toComplianceData($store));
            $store->update(['user_submitted' => 1]);
        }

        return redirect()->to(URL::signedRoute('dealer.dealer.settings.form', ['store' => $store->id]));
    }

    private function resolveStore(Request $request): Store
    {
        $storeId = $request->query('store');

        abort_unless(is_numeric($storeId), 404);

        $store = Store::query()->find((int) $storeId);

        abort_unless($store instanceof Store, 404);

        return $store;
    }

    /**
     * The `user_submitted` column is array-cast; a completed form stores the
     * integer 1, so an empty/unsubmitted store reads back as null.
     */
    private function isSubmitted(Store $store): bool
    {
        $value = $store->getAttribute('user_submitted');

        return $value === 1 || $value === '1';
    }
}
