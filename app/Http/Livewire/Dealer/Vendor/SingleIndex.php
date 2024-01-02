<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Livewire\Component;

class SingleIndex extends Component
{
    protected $listeners = ['refreshVendors' => '$refresh'];

    public function render()
    {
        return view('livewire.dealer.vendor.single-index', [
            'vendors' => Vendor::orderBy('name')->get(),
        ]);
    }
}
