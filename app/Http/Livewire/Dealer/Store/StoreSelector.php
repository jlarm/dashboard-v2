<?php

namespace App\Http\Livewire\Dealer\Store;

use Livewire\Component;

class StoreSelector extends Component
{
    public function render()
    {
        return view('livewire.dealer.store.store-selector', [
            'stores' => auth()->user()->stores,
        ]);
    }
}
