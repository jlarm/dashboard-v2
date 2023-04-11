<?php

namespace App\Http\Livewire\Dealer\Manual;

use App\Models\Dealer\Manual\Isp;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Livewire\Component;

class IspCard extends Component
{
    public function download()
    {
        $isp = Isp::latest()->first();
        $pdf = PDF::loadView('dealer.manual.pdf.isp', compact('isp'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'isp-manual'.now()->format('Ymd').'.pdf');
    }
    public function render()
    {
        return view('livewire.dealer.manual.isp-card', [
            'isp' => Isp::latest()->first()
        ]);
    }
}
