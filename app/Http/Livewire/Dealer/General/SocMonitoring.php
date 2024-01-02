<?php

namespace App\Http\Livewire\Dealer\General;

use App\Models\Dealer\Store;
use Illuminate\Http\Request;
use Livewire\Component;

class SocMonitoring extends Component
{
    public $monitoring;

    public function mount(Request $request)
    {
        $this->monitoring = Store::query()
            ->where('name', $request->get('store')?->name)
            ->orWhere('id', 1)
            ->first();
    }

    public function render()
    {
        return view('livewire.dealer.general.soc-monitoring');
    }
}
