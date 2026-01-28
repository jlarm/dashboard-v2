<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Livewire\Component;

class StoreIndexItem extends Component
{
    public Vendor $vendor;
    public $noCount;
    public $array = [];

    public function mount()
    {
        foreach ($this->vendor->getAttributes() as $key => $value) {
            if (str_starts_with($key, 'q') && str_ends_with($key, 'a')) {
                if ($value === 'no') {
                    $this->array[] = $value;
                }
            }
        }
        $this->noCount = count($this->array);
    }

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
