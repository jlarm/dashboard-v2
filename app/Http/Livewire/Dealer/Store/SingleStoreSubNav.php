<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Livewire\Component;

class SingleStoreSubNav extends Component
{
    public Store $store;
    public function render()
    {
        return view('livewire.dealer.store.single-store-sub-nav', [
            'stores' => Store::orderBy('name')
                ->whereNot('id', 1)->get(),
        ]);
    }
}
