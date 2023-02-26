<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['refreshVendors' => '$refresh'];

    public function render()
    {
        return view('livewire.dealer.vendor.index', [
            'vendors' => Vendor::all(),
        ]);
    }
}
