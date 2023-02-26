<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Livewire\Component;

class IndexItem extends Component
{
    public Vendor $vendor;

    public function render()
    {
        return view('livewire.dealer.vendor.index-item');
    }
}
