<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;
use App\Models\Dealership;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Component;

class UpcomingAudits extends Component
{
    public function render(): View
    {
        return view('livewire.central.upcoming-audits', [
            'dealershipGroups' => $this->dealershipGroups(),
            'quarterEnd' => now()->endOfQuarter(),
            'daysRemaining' => (int) now()->diffInDays(now()->endOfQuarter(), false),
        ]);
    }

    private function dealershipGroups(): Collection
    {
        $user = auth()->user();
        $quarterStart = now()->startOfQuarter();
        $quarterEnd = now()->endOfQuarter();

        $dealerships = $user->hasAnyRole('super-admin|Consultant')
            ? Dealership::query()->orderBy('name')->get()
            : $user->dealerships->sortBy('name')->values();

        /** @var array<string, array{name: string, domain: string|null}> $dealershipMap */
        $dealershipMap = $dealerships->mapWithKeys(fn (Dealership $d): array => [
            $d->id => ['name' => $d->name, 'domain' => $d->domain()],
        ])->all();

        $dealershipIds = array_keys($dealershipMap);
        $cacheKey = 'upcoming-audits-'.now()->year.'-Q'.now()->quarter.'-'.md5(implode(',', $dealershipIds));

        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($dealershipIds, $dealershipMap, $quarterStart, $quarterEnd): Collection {
            $groups = collect();

            tenancy()->runForMultiple($dealershipIds, function ($tenant) use ($dealershipMap, $quarterStart, $quarterEnd, &$groups): void {
                $incompleteStores = Store::query()
                    ->orderBy('name')
                    ->get()
                    ->map(fn (Store $store): ?array => $this->auditStatusForStore($store, $quarterStart, $quarterEnd))
                    ->filter()
                    ->values();

                if ($incompleteStores->isEmpty()) {
                    return;
                }

                $groups->push([
                    'name' => $dealershipMap[$tenant->id]['name'],
                    'domain' => $dealershipMap[$tenant->id]['domain'],
                    'stores' => $incompleteStores,
                ]);
            });

            return $groups->sortBy('name')->values();
        });
    }

    /**
     * Returns audit status for a store if it has any incomplete audits, otherwise null.
     *
     * @return array{name: string, missing_osha: bool, missing_body_shop: bool|null, missing_finance: bool, missing_deal_jacket: bool}|null
     */
    private function auditStatusForStore(Store $store, mixed $quarterStart, mixed $quarterEnd): ?array
    {
        $hasOsha = OshaAudit::query()
            ->where('store_id', $store->id)
            ->where('draft', false)
            ->whereBetween('audit_date', [$quarterStart, $quarterEnd])
            ->exists();

        $hasBodyShopEver = BodyShopAudit::query()
            ->where('store_id', $store->id)
            ->exists();

        $hasBodyShopThisQuarter = $hasBodyShopEver
            ? BodyShopAudit::query()
                ->where('store_id', $store->id)
                ->where('draft', false)
                ->whereBetween('audit_date', [$quarterStart, $quarterEnd])
                ->exists()
            : null;

        $hasFinance = FinanceAudit::query()
            ->where('store_id', $store->id)
            ->where('draft', false)
            ->whereBetween('audit_date', [$quarterStart, $quarterEnd])
            ->exists();

        $hasDealJacket = DealJacketGroup::query()
            ->where('store_id', $store->id)
            ->where('completed', true)
            ->whereBetween('created_at', [$quarterStart, $quarterEnd])
            ->exists();

        $missingBodyShop = $hasBodyShopEver ? ! $hasBodyShopThisQuarter : null;
        $allComplete = $hasOsha && $hasFinance && $hasDealJacket && $missingBodyShop !== true;

        if ($allComplete) {
            return null;
        }

        return [
            'name' => $store->name,
            'missing_osha' => ! $hasOsha,
            'missing_body_shop' => $missingBodyShop,
            'missing_finance' => ! $hasFinance,
            'missing_deal_jacket' => ! $hasDealJacket,
        ];
    }
}
