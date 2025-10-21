<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class DealJacketIndexItem extends Component
{
    public Store $store;
    public DealJacketGroup $dealJacketGroup;
    public DealJacket $dealJacket;

    public function mount(): void
    {
        $this->store = Store::find(app('currentStore'));
    }

    public function grade(): string
    {
        return match (true) {
            $this->dealJacket->percentage >= 90 => 'A',
            $this->dealJacket->percentage >= 80 => 'B',
            $this->dealJacket->percentage >= 70 => 'C',
            $this->dealJacket->percentage >= 60 => 'D',
            $this->dealJacket->percentage >= 50 => 'F',
            default => 'N/A',
        };
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.deal-jacket-index-item');
    }
}
