<?php

namespace App\Http\Livewire\Dealer\Manual;

use App\Models\Dealer\Manual\Osha;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Livewire\Component;

class OshaCard extends Component
{
    public function download()
    {
        $osha = Osha::latest()->first();
        $pdf = PDF::loadView('dealer.manual.pdf.osha', compact('osha'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'osha-manual'.now()->format('Ymd').'.pdf');
    }
    public function render()
    {
        return view('livewire.dealer.manual.osha-card', [
            'osha' => Osha::latest()->first()
        ]);
    }
}
