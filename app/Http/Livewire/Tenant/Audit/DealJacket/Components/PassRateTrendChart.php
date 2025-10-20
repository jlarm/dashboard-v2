<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket\Components;

use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\View\View;
use Livewire\Component;

class PassRateTrendChart extends Component
{
    protected $listeners = ['refreshDealJacketGroups' => '$refresh'];

    public function render(): View
    {
        $storeId = app('currentStore');

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
}
