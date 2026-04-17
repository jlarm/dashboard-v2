<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Download extends Component
{
    public Document $document;

    public function download()
    {
        return Storage::disk('central-docs')->download($this->document->file_name);
    }

    public function render(): Factory|View
    {
        return view('livewire.central.docs.download');
    }
}
