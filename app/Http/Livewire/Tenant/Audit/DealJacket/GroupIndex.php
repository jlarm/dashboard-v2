<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class GroupIndex extends Component
{
    use WithPagination;

    protected $listeners = ['refreshDealJacketGroups' => '$refresh'];

    public function render(): View
    {
        $storeId = app('currentStore');

        $groups = DealJacketGroup::query()
            ->where('store_id', $storeId)
            ->when(! auth()->user()->hasAnyRole(['super-admin', 'Consultant']), function ($query) {
                $query->where('completed', true);
            })
            ->withCount('dealJackets')
            ->withSum('dealJackets as total_high_risk', 'total_high_risk')
            ->withSum('dealJackets as total_passed', 'total_passed')
            ->withSum('dealJackets as total_failed', 'total_failed')
            ->latest()
            ->paginate(20);

        return view('livewire.tenant.audit.deal-jacket.group-index', [
            'dealJacketGroups' => $groups,
        ]);
    }
}
