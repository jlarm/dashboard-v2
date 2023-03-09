<?php

namespace App\Http\Livewire\Dealer\General;

use App\Models\Dealer\Store;
use Livewire\Component;

class DealershipName extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.general.dealership-name');
    }
}
