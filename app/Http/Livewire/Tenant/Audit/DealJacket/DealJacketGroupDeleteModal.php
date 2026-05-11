<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Component;

class DealJacketGroupDeleteModal extends Component
{
    public int $dealJacketGroup;
    public DealJacketGroup $group;

    public function mount(): void
    {
        $this->group = DealJacketGroup::query()->findOrFail($this->dealJacketGroup);
    }

    public function delete(): void
    {
        Gate::authorize('delete', $this->group);

        $this->group->delete();

        $this->dispatch('refreshDealJacketGroups')->to('tenant.audit.deal-jacket.group-index');
        $this->dispatch('refreshDealJacketGroups')->to('tenant.audit.deal-jacket.components.pass-rate-trend-chart');
        $this->dispatch('refreshDealJacketGroups')->to('tenant.audit.deal-jacket.components.common-issues-chart');

        session()->flash('success', 'Deal Jacket Group Deleted');
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.deal-jacket-group-delete-modal');
    }
}
