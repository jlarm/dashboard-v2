<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['refreshVendors' => '$refresh'];

    public function render()
    {
        return view('livewire.dealer.vendor.index', [
            'vendors' => Vendor::query()
                ->orderBy('name')
                ->with('store')
                ->get()
                ->groupBy('store_id')
        ]);
    }
}
