<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class OldDownload extends Component
{
    public Vendor $vendor;

    public function download()
    {
        try {
            $view = view('dealer.vendor.pdf.old-form-submission', ['vendor' => $this->vendor])->render();

            $pdf = Browsershot::html($view)
                ->noSandbox()
                ->showBackground()
                ->margins(10, 10, 10, 10)
                ->format('A4')
                ->pdf();

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf;
            }, $this->vendor->name . '-vendor-form.pdf');
        } catch (\Exception $e) {
            \Log::log('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.dealer.vendor.old-download');
    }
}
