<?php

namespace App\Http\Livewire\Dealer\General;

use App\Models\Dealer\Store;
use Livewire\Component;

class SocMonitoring extends Component
{
    public $active;

    public function mount()
    {
        $this->active = Store::query()
            ->where('id', 1)
            ->where('active_monitoring', true)
            ->first()
            ?->pluck('monitoring_start_date');
    }

    public function render()
    {
        return view('livewire.dealer.general.soc-monitoring');
    }
}
