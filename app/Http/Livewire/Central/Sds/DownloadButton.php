<?php

namespace App\Http\Livewire\Central\Sds;

use App\Models\Sds;
use Livewire\Component;

class DownloadButton extends Component
{
    public Sds $sds;

    public $file;

    public function download()
    {
        return \Storage::disk('sds-sheets')->download($this->sds->pdf_path);
    }

    public function render()
    {
        return view('livewire.central.sds.download-button');
    }
}
