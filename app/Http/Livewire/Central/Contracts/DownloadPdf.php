<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DownloadPdf extends Component
{
    public Contract $contract;

    public function download()
    {
        return Storage::disk('armpcon')->download($this->contract->pdf_path);
        //        return response()->download(\Storage::disk('armpcon')->get($this->contract->pdf_path, now()->minutes(5), []));
    }

    public function render(): Factory|View
    {
        return view('livewire.central.contracts.download-pdf');
    }
}
