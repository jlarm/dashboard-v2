<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Settings;

use App\Models\Dealer\Store;
use Livewire\Component;

class StoreDetails extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.store.single-store.settings.store-details');
    }
}
