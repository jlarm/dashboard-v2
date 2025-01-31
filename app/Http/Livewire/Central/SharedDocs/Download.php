<?php

namespace App\Http\Livewire\Central\SharedDocs;

use App\Models\SharedDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class Download extends Component
{
    public SharedDocument $sharedDocument;

    public function download()
    {
        return Storage::disk('public')->download($this->sharedDocument->file_name);
    }

    public function render(): View
    {
        return view('livewire.central.shared-docs.download');
    }
}
