<?php

namespace App\Http\Livewire\Tenant\Audit\Fit;

use App\Models\FitTestDoc;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public FitTestDoc $fitTestDoc;

    public function download()
    {
        return response()->streamDownload(function () {
            echo Storage::disk('dealer-docs')->get($this->fitTestDoc->file_path);
        }, basename('fit-test.pdf'));
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.fit.index-item');
    }
}
