<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Livewire\Component;

class SingleStoreSettings extends Component
{
    public Store $store;
    public function render()
    {
        return view('livewire.dealer.store.single-store-settings')->layout('components.dealer-app');
    }
}
