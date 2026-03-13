<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class GroupIndexItem extends Component
{
    public Store $store;
    public DealJacketGroup $dealJacketGroup;

    public function mount(): void
    {
        $this->store = Store::query()->findOrFail($this->dealJacketGroup->store_id);
    }

    public function grade(): string
    {
        $avg = $this->dealJacketGroup->average_percentage;

        if ($avg === null) {
            return 'N/A';
        }

        return match (true) {
            $avg >= 90 => 'A',
            $avg >= 80 => 'B',
            $avg >= 70 => 'C',
            $avg >= 60 => 'D',
            default => 'F',
        };
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.group-index-item');
    }
}
