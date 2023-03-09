<?php

namespace App\Http\Livewire\Dealer\Store\Multi;

use App\Models\Dealer\Vendor;
use Livewire\Component;

class VendorIndexItem extends Component
{
    public Vendor $vendor;

    public function render()
    {
        return view('livewire.dealer.store.multi.vendor-index-item');
    }
}
