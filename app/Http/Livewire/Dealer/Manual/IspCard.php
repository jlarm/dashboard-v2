<?php

namespace App\Http\Livewire\Dealer\Manual;

use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Store;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class IspCard extends Component
{
    public Store $store;
    public function download()
    {
        $isp = Isp::with('store')->latest()->first();
        $fileName = 'isp-manual'.now()->format('Ymd').'.pdf';
        $storgePath = storage_path('app/' . $fileName);

        $html = view('dealer.manual.pdf.isp', [
            'isp' => $isp
        ])->render();

        $ispManual = Browsershot::html($html)
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->scale(0.75)
            ->waitUntilNetworkIdle()
            ->save($storgePath);

        // open pdf in new tab
        return response()->stream(function () use ($storgePath) {
            echo file_get_contents($storgePath);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"'
        ]);

        // refresh current page
//        return redirect()->route('dealer.manual.index');
    }
    public function render()
    {
        return view('livewire.dealer.manual.isp-card', [
            'isp' => Isp::latest()->first()
        ]);
    }
}
