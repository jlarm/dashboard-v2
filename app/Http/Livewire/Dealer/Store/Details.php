<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Livewire\Component;

class Details extends Component
{
    public Store $store;
    protected $listeners = ['refreshStoreDetails' => '$refresh'];

    public function render()
    {
        return view('livewire.dealer.store.details');
    }
}
