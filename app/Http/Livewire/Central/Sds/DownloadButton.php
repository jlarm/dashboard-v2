<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Sds;

use App\Models\Sds;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DownloadButton extends Component
{
    public Sds $sds;
    public $file;

    public function download()
    {
        return Storage::disk('sds-sheets')->download($this->sds->file_name, $this->sds->name.'.pdf');
    }

    public function render(): Factory|View
    {
        return view('livewire.central.sds.download-button');
    }
}
