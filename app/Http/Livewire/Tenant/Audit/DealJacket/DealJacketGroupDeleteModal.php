<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacketGroup;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class DealJacketGroupDeleteModal extends Modal
{
    public int $dealJacketGroup;
    public DealJacketGroup $group;

    public function mount(): void
    {
        $this->group = DealJacketGroup::findOrFail($this->dealJacketGroup);
    }

    public function delete(): void
    {
        Gate::authorize('delete', $this->group);

        $this->group->delete();

        $this->emitTo('tenant.audit.deal-jacket.group-index', 'refreshDealJacketGroups');
        $this->emitTo('tenant.audit.deal-jacket.pass-rate-trend-chart', 'refreshDealJacketGroups');
        $this->emitTo('tenant.audit.deal-jacket.common-issues-chart', 'refreshDealJacketGroups');

        $this->close();

        Notification::make()
            ->title('Deal Jacket Group Deleted')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.deal-jacket-group-delete-modal');
    }
}
