<?php

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use Livewire\Component;
use Storage;

class Download extends Component
{
    public Document $document;

    public function download()
    {
        return Storage::disk('central-docs')->download($this->document->file_name);
    }

    public function render()
    {
        return view('livewire.central.docs.download');
    }
}
