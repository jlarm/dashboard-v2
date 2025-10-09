<?php

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Livewire\Component;
use Storage;

class DownloadPdf extends Component
{
    public Contract $contract;

    public function download()
    {
        return Storage::disk('armpcon')->download($this->contract->pdf_path);
        //        return response()->download(\Storage::disk('armpcon')->get($this->contract->pdf_path, now()->minutes(5), []));
    }

    public function render()
    {
        return view('livewire.central.contracts.download-pdf');
    }
}
