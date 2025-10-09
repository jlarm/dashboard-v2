<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\VendorForm;
use Exception;
use Livewire\Component;
use Log;
use Spatie\Browsershot\Browsershot;

class Download extends Component
{
    public VendorForm $vendorForm;

    public function download()
    {
        try {
            $view = view('dealer.vendor.pdf.form-submission', ['vendor' => $this->vendorForm])->render();

            $pdf = Browsershot::html($view)
                ->noSandbox()
                ->showBackground()
                ->margins(10, 10, 10, 10)
                ->format('A4')
                ->pdf();

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf;
            }, 'vendor-form.pdf');
        } catch (Exception $e) {
            Log::log('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.dealer.vendor.download');
    }
}
