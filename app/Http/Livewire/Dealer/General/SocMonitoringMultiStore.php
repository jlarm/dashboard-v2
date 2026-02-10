<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\General;

use App\Models\Dealer\Store;
use Livewire\Component;

class SocMonitoringMultiStore extends Component
{
    public Store $store;
    public $active;

    public function mount(): void
    {
        $this->active = Store::query()
            ->where('id', $this->store->id)
            ->where('active_monitoring', true)
            ->first()
            ?->pluck('monitoring_start_date');
    }

    public function render()
    {
        return view('livewire.dealer.general.soc-monitoring-multi-store');
    }
}
