<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacket;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class DealJacketDeleteModal extends Modal
{
    public $dealJacket;

    public function mount($dealJacket): void
    {
        $this->dealJacket = DealJacket::findOrFail($dealJacket);
    }

    public function delete(): void
    {
        Gate::authorize('delete', $this->dealJacket);

        $this->dealJacket->delete();

        $this->emit('refreshDealJackets');

        $this->close();

        Notification::make()
            ->title('Deal Jacket Deleted')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.deal-jacket-delete-modal');
    }
}
