<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket\Components;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class PassRateTrendChart extends Component
{
    #[Override]
    protected $listeners = ['refreshDealJacketGroups' => '$refresh'];

    public function render(): View
    {
        $storeId = $this->resolveStoreId();

        $groups = DealJacketGroup::query()
            ->where('store_id', $storeId)
            ->where('completed', true)
            ->withSum('dealJackets as total_passed', 'total_passed')
            ->withSum('dealJackets as total_failed', 'total_failed')
            ->latest()
            ->limit(8)
            ->get()
            ->reverse();

        $labels = $groups->map(fn ($group) => $group->created_at->format('M \'y'))->values()->toArray();
        $data = $groups->map(fn ($group) => $group->pass_rate ?? 0)->values()->toArray();

        return view('livewire.tenant.audit.deal-jacket.components.pass-rate-trend-chart', [
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    private function resolveStoreId(): ?int
    {
        $currentStore = app()->bound('currentStore') ? resolve('currentStore') : null;

        if (is_numeric($currentStore)) {
            return (int) $currentStore;
        }

        $scopedStoreIds = app()->bound('scopedStoreIds') ? resolve('scopedStoreIds') : collect();
        $firstScopedStoreId = $scopedStoreIds->first();

        if (is_numeric($firstScopedStoreId)) {
            return (int) $firstScopedStoreId;
        }

        $fallbackStoreId = Store::query()->orderBy('id')->value('id');

        return is_numeric($fallbackStoreId) ? (int) $fallbackStoreId : null;
    }
}
