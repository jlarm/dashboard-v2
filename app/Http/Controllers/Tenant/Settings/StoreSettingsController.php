<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Settings;

use App\Domain\Tenant\StoreSettings\Actions\ResetStoreCourses;
use App\Domain\Tenant\StoreSettings\Actions\UpdateComplianceSection;
use App\Domain\Tenant\StoreSettings\Actions\UpdateGeneralSection;
use App\Domain\Tenant\StoreSettings\Actions\UpdateManagersSection;
use App\Domain\Tenant\StoreSettings\Queries\GetComplianceSection;
use App\Domain\Tenant\StoreSettings\Queries\GetGeneralSection;
use App\Domain\Tenant\StoreSettings\Queries\GetManagersSection;
use App\Domain\Tenant\StoreSettings\Queries\GetStoreResettableUsers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreSettings\ResetStoreCoursesRequest;
use App\Http\Requests\Tenant\StoreSettings\UpdateComplianceRequest;
use App\Http\Requests\Tenant\StoreSettings\UpdateGeneralRequest;
use App\Http\Requests\Tenant\StoreSettings\UpdateManagersRequest;
use App\Models\Dealer\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
        GetComplianceSection $getComplianceSection,
        GetStoreResettableUsers $getStoreResettableUsers,
    ): InertiaResponse|RedirectResponse {
        $section = $request->route()->defaults['section'] ?? self::SECTION_GENERAL;
        abort_unless(is_string($section) && in_array($section, self::SECTIONS, true), 404);

        $store = $this->resolveStore();

        if (! $store instanceof Store) {
            return to_route('dealer.settings.global');
        }

        $user = $request->user();
        $search = (string) $request->string('search');

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
            'search' => $search,
            'general' => Inertia::defer(static fn (): array => $getGeneralSection->handle($store)->toArray()),
            'managers' => Inertia::defer(static fn (): array => $getManagersSection->handle($store)->toArray()),
            'compliance' => Inertia::defer(static fn (): array => $getComplianceSection->handle($store)->toArray()),
            'resettableUsers' => Inertia::defer(static function () use ($section, $getStoreResettableUsers, $store, $search): array {
                if ($section !== self::SECTION_RESET_COURSES) {
                    return [];
                }

                try {
                    return array_map(
                        static fn ($u): array => $u->toArray(),
                        $getStoreResettableUsers->handle($store, $search),
                    );
                } catch (Throwable $e) {
                    Log::error('Failed to load resettable users', [
                        'store_id' => $store->id,
                        'message' => $e->getMessage(),
                    ]);

                    return [];
                }
            }),
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

    public function updateCompliance(
        UpdateComplianceRequest $request,
        Store $store,
        UpdateComplianceSection $updateComplianceSection,
    ): RedirectResponse {
        try {
            $updateComplianceSection->handle($store, $request->toData());
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('flash.error', 'We could not save the compliance information. Please try again.');
        }

        return back()->with('flash.success', 'Compliance information saved.');
    }

    public function resetCourses(
        ResetStoreCoursesRequest $request,
        Store $store,
        ResetStoreCourses $resetStoreCourses,
    ): RedirectResponse {
        try {
            $resetStoreCourses->handle($store, $request->toData(), $request->user());
        } catch (Throwable $e) {
            report($e);

            return back()->with('flash.error', 'We could not reset courses. Please try again.');
        }

        $message = $request->toData()->isSelectedUsers()
            ? 'Selected courses reset successfully.'
            : 'Courses reset successfully.';

        return back()->with('flash.success', $message);
    }

    public function downloadCompliance(Store $store): StreamedResponse
    {
        $this->authorize('update', $store);

        try {
            $html = view('dealer.settings.ComplianceInfoDownloadView', ['store' => $store])->render();

            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(20, 10, 20, 10)
                ->pdf();
        } catch (Throwable $e) {
            report($e);
            abort(503, 'We could not generate the compliance PDF. Please try again later.');
        }

        $filename = str_replace(' ', '-', mb_strtolower((string) $store->name)).'-compliance-info-'.now()->format('m-d-y').'.pdf';

        return response()->streamDownload(static function () use ($pdf): void {
            echo $pdf;
        }, $filename, ['Content-Type' => 'application/pdf']);
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
