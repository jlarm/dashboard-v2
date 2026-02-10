<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Sds;

use Illuminate\Support\Facades\Storage;
use App\Models\Sds;
use Livewire\Component;

class DownloadButton extends Component
{
    public Sds $sds;
    public $file;

    public function download()
    {
        return Storage::disk('sds-sheets')->download($this->sds->file_name, $this->sds->name.'.pdf');
    }

    public function render()
    {
        return view('livewire.central.sds.download-button');
    }
}
