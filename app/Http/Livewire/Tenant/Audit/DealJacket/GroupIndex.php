<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class GroupIndex extends Component
{
    use WithPagination;

    protected $listeners = ['refreshDealJacketGroups' => '$refresh'];

    public function render(): View
    {
        $storeId = $this->resolveStoreId();

        $groups = DealJacketGroup::query()
            ->where('store_id', $storeId)
            ->unless(auth()->user()->hasAnyRole(['super-admin', 'Consultant']), function ($query): void {
                $query->where('completed', true);
            })
            ->withCount('dealJackets')
            ->withSum('dealJackets as total_high_risk', 'total_high_risk')
            ->withSum('dealJackets as total_passed', 'total_passed')
            ->withSum('dealJackets as total_failed', 'total_failed')
            ->withAvg('dealJackets as average_percentage', 'percentage')
            ->latest()
            ->paginate(20);

        return view('livewire.tenant.audit.deal-jacket.group-index', [
            'dealJacketGroups' => $groups,
        ]);
    }

    private function resolveStoreId(): ?int
    {
        $currentStore = app()->bound('currentStore') ? app('currentStore') : null;

        if (is_numeric($currentStore)) {
            return (int) $currentStore;
        }

        $scopedStoreIds = app()->bound('scopedStoreIds') ? app('scopedStoreIds') : collect();
        $firstScopedStoreId = $scopedStoreIds->first();

        if (is_numeric($firstScopedStoreId)) {
            return (int) $firstScopedStoreId;
        }

        $fallbackStoreId = Store::query()->orderBy('id')->value('id');

        return is_numeric($fallbackStoreId) ? (int) $fallbackStoreId : null;
    }
}
