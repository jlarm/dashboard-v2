<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop;

use App\Models\Dealer\Store;
use Livewire\Component;

class Create extends Component
{
    public Store $store;
    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.body-shop.create')->layout('components.dealer-app');
    }
}
