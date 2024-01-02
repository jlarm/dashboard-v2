<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Scan;

use App\Models\Dealer\Store;
use Livewire\Component;

class IndexList extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.store.single-store.scan.index-list');
    }
}
