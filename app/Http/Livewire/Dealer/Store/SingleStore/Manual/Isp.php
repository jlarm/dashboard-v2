<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Manual;

use App\Models\Dealer\Store;
use Livewire\Component;

class Isp extends Component
{
    public Store $store;
    public function render()
    {
        return view('livewire.dealer.store.single-store.manual.isp')->layout('components.dealer-app');
    }
}
