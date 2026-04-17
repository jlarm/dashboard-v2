<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class DealJacketIndex extends Component
{
    public DealJacketGroup $dealJacketGroup;

    #[Override]
    protected $listeners = ['refreshDealJackets' => '$refresh'];

    public function render(): View
    {
        $dealJackets = $this->dealJacketGroup
            ->dealJackets()
            ->select('id', 'uuid', 'deal_jacket_group_id', 'audit_date', 'customer_name', 'customer_deal_number', 'total_passed', 'total_failed', 'total_high_risk', 'percentage')
            ->get();

        return view('livewire.tenant.audit.deal-jacket.deal-jacket-index', [
            'dealJackets' => $dealJackets,
            'totalPassed' => $dealJackets->sum('total_passed'),
            'totalFailed' => $dealJackets->sum('total_failed'),
            'totalHighRisk' => $dealJackets->sum('total_high_risk'),
        ]);
    }
}
