<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket\Components;

use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Component;

class MarkCompleteModal extends Component
{
    use AuthorizesRequests;

    public int $dealJacketGroupId;
    public DealJacketGroup $dealJacketGroup;

    public function mount(): void
    {
        $this->dealJacketGroup = DealJacketGroup::query()->findOrFail($this->dealJacketGroupId);
    }

    public function markComplete(): void
    {
        Gate::authorize('update', $this->dealJacketGroup);

        $this->dealJacketGroup->update(['completed' => true]);

        $this->dispatch('refreshDealJacketGroups')->to('tenant.audit.deal-jacket.group-index');
        $this->dispatch('refreshDealJacketGroups')->to('tenant.audit.deal-jacket.components.pass-rate-trend-chart');
        $this->dispatch('refreshDealJacketGroups')->to('tenant.audit.deal-jacket.components.common-issues-chart');

        session()->flash('success', 'Deal Jacket Group Completed');
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.components.mark-complete-modal');
    }
}
