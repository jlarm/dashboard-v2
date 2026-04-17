<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket\Components;

use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class TotalsProgressBar extends Component
{
    public DealJacketGroup $dealJacketGroup;

    #[Override]
    protected $listeners = ['refreshDealJackets' => '$refresh'];

    public function render(): View
    {
        $dealJackets = $this->dealJacketGroup
            ->dealJackets()
            ->select('total_passed', 'total_failed', 'total_high_risk')
            ->get();

        return view('livewire.tenant.audit.deal-jacket.components.totals-progress-bar', [
            'totalPassed' => $dealJackets->sum('total_passed'),
            'totalFailed' => $dealJackets->sum('total_failed'),
            'totalHighRisk' => $dealJackets->sum('total_high_risk'),
        ]);
    }
}
