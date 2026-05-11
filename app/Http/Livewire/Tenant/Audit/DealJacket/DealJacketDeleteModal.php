<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacket;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Component;

class DealJacketDeleteModal extends Component
{
    public $dealJacket;

    public function mount($dealJacket): void
    {
        $this->dealJacket = DealJacket::query()->findOrFail($dealJacket);
    }

    public function delete(): void
    {
        Gate::authorize('delete', $this->dealJacket);

        $this->dealJacket->delete();

        $this->dispatch('refreshDealJackets');

        session()->flash('success', 'Deal Jacket Deleted');
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.deal-jacket-delete-modal');
    }
}
