<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer\Store;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SettingsController extends Controller
{
    private const string SECTION_GENERAL = 'general';

    private const string SECTION_MANAGERS = 'managers';

    private const string SECTION_COMPLIANCE = 'compliance';

    private const string SECTION_RESET_COURSES = 'reset-courses';

    private const string SECTION_RIDGEBACK = 'ridgeback';

    public function __invoke(): View
    {
        return $this->renderSection(self::SECTION_GENERAL);
    }

    public function show(string $section): View
    {
        abort_unless(in_array($section, $this->sections(), true), 404);

        return $this->renderSection($section);
    }

    private function renderSection(string $section): View
    {
        $scopedStoreIds = $this->resolveScopedStoreIds();

        /** @var Store|null $currentStore */
        $currentStore = app()->bound('currentStoreModel') ? resolve('currentStoreModel') : null;
        if ($currentStore instanceof Store) {
            return view('dealer.store.settings', [
                'section' => $section,
                'store' => $currentStore,
                'stores' => collect(),
            ]);
        }

        if ($scopedStoreIds->count() === 1) {
            $store = Store::query()
                ->whereIn('id', $scopedStoreIds)
                ->orderBy('name')
                ->first();

            abort_unless($store instanceof Store, 404);

            return view('dealer.store.settings', [
                'section' => $section,
                'store' => $store,
                'stores' => collect(),
            ]);
        }

        $stores = $scopedStoreIds->isEmpty()
            ? collect()
            : Store::query()
                ->whereIn('id', $scopedStoreIds)
                ->withCount('users')
                ->orderBy('name')
                ->get();

        abort_unless($stores->isNotEmpty(), 404);

        return view('dealer.store.settings', [
            'section' => $section,
            'store' => null,
            'stores' => $stores,
        ]);
    }

    private function sections(): array
    {
        return [
            self::SECTION_GENERAL,
            self::SECTION_MANAGERS,
            self::SECTION_COMPLIANCE,
            self::SECTION_RESET_COURSES,
            self::SECTION_RIDGEBACK,
        ];
    }

    private function resolveScopedStoreIds(): Collection
    {
        if (app()->bound('scopedStoreIds')) {
            /** @var Collection $storeIds */
            $storeIds = resolve('scopedStoreIds');

            $normalizedStoreIds = $storeIds->map(static fn ($id): int => (int) $id)->values();

            if ($normalizedStoreIds->isNotEmpty()) {
                return $normalizedStoreIds;
            }
        }

        $user = auth()->user();

        if (! $user) {
            return collect();
        }

        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return $user->current_store_id !== null
                ? collect([(int) $user->current_store_id])
                : Store::query()->pluck('id');
        }

        $assignedStoreIds = $user->stores()->pluck('stores.id')->map(static fn ($id): int => (int) $id);

        if ($user->current_store_id === null) {
            return $assignedStoreIds;
        }

        if ($assignedStoreIds->contains($user->current_store_id)) {
            return collect([(int) $user->current_store_id]);
        }

        return collect();
    }
}
