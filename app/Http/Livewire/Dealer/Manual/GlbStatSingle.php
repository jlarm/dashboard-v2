<?php

namespace App\Http\Livewire\Dealer\Manual;

use App\Models\Dealer\Manual\Glb;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Livewire\Component;

class GlbStatSingle extends Component
{
    public Glb $manual;

    public function download()
    {
        $manual = Glb::where('id', $this->manual->id)->first();
        $pdf = PDF::loadView('dealer.manual.pdf.glb', compact('manual'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'glbisp'.now().'.pdf');
    }
}
