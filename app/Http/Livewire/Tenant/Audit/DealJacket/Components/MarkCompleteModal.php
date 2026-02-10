<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket\Components;

use App\Models\Dealer\Audit\DealJacketGroup;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class MarkCompleteModal extends Modal
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

        $this->emitTo('tenant.audit.deal-jacket.group-index', 'refreshDealJacketGroups');
        $this->emitTo('tenant.audit.deal-jacket.pass-rate-trend-chart', 'refreshDealJacketGroups');
        $this->emitTo('tenant.audit.deal-jacket.common-issues-chart', 'refreshDealJacketGroups');

        $this->close();

        Notification::make()
            ->title('Deal Jacket Group Completed')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.components.mark-complete-modal');
    }
}
