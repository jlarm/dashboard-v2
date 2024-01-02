<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Livewire\Component;

class StoreIndexItem extends Component
{
    public Vendor $vendor;

    public function download()
    {
        $vendor = Vendor::where('id', $this->vendor->id)->first();
        $pdf = PDF::loadView('dealer.vendor.pdf.form-submission', compact('vendor'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $this->vendor->name.now()->format('Ymd').'.pdf');
    }

    public function render()
    {
        return view('livewire.dealer.vendor.store-index-item');
    }
}
