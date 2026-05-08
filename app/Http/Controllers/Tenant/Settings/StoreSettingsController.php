<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Settings;

use App\Domain\Tenant\StoreSettings\Actions\UpdateGeneralSection;
use App\Domain\Tenant\StoreSettings\Actions\UpdateManagersSection;
use App\Domain\Tenant\StoreSettings\Queries\GetGeneralSection;
use App\Domain\Tenant\StoreSettings\Queries\GetManagersSection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreSettings\UpdateGeneralRequest;
use App\Http\Requests\Tenant\StoreSettings\UpdateManagersRequest;
use App\Models\Dealer\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Throwable;

class StoreSettingsController extends Controller
{
    private const string SECTION_GENERAL = 'general';

    private const string SECTION_MANAGERS = 'managers';

    private const string SECTION_COMPLIANCE = 'compliance';

    private const string SECTION_RESET_COURSES = 'reset-courses';

    private const array SECTIONS = [
        self::SECTION_GENERAL,
        self::SECTION_MANAGERS,
        self::SECTION_COMPLIANCE,
        self::SECTION_RESET_COURSES,
    ];

    public function index(
        Request $request,
        GetGeneralSection $getGeneralSection,
        GetManagersSection $getManagersSection,
    ): InertiaResponse|RedirectResponse {
        $section = $request->route()->defaults['section'] ?? self::SECTION_GENERAL;
        abort_unless(is_string($section) && in_array($section, self::SECTIONS, true), 404);

        $store = $this->resolveStore();

        if (! $store instanceof Store) {
            return to_route('dealer.settings.global');
        }

        $user = $request->user();

        return Inertia::render('tenant/settings/StoreSettings', [
            'section' => $section,
            'store' => [
                'id' => $store->id,
                'name' => $store->name,
            ],
            'can' => [
                'update' => $user?->can('update', $store) ?? false,
                'manage_dealerships' => $user?->can('create-dealerships') ?? false,
            ],
            'general' => Inertia::defer(static fn (): array => $getGeneralSection->handle($store)->toArray()),
            'managers' => Inertia::defer(static fn (): array => $getManagersSection->handle($store)->toArray()),
        ]);
    }

    public function updateGeneral(
        UpdateGeneralRequest $request,
        Store $store,
        UpdateGeneralSection $updateGeneralSection,
    ): RedirectResponse {
        try {
            $updateGeneralSection->handle($store, $request->toData());
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('flash.error', 'We could not save the settings. Please try again.');
        }

        return back()->with('flash.success', 'Settings saved.');
    }

    public function updateManagers(
        UpdateManagersRequest $request,
        Store $store,
        UpdateManagersSection $updateManagersSection,
    ): RedirectResponse {
        try {
            $updateManagersSection->handle($store, $request->toData());
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('flash.error', 'We could not save the manager list. Please try again.');
        }

        return back()->with('flash.success', 'Manager list saved.');
    }

    private function resolveStore(): ?Store
    {
        if (app()->bound('currentStoreModel')) {
            $store = resolve('currentStoreModel');

            if ($store instanceof Store) {
                return $store;
            }
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
