<?php

namespace App\Http\Livewire\Central\SharedDocs;

use App\Models\SharedDocument;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public SharedDocument $sharedDocument;

    public function fileName(): string
    {
        return str_replace('shared-documents/', '', $this->sharedDocument->file_name);
    }

    public function render(): View
    {
        return view('livewire.central.shared-docs.index-item');
    }
}
