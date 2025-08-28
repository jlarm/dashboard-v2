<?php

namespace App\Http\Livewire\Dealer\Docs;

use App\Models\DealerDoc;
use App\Models\SharedDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['saved' => '$refresh'];

    public function download($doc)
    {
        return tenancy()->central(fn () => Storage::disk('public')->download($doc['file_name']));
    }

    public function render(): View
    {
        $sharedDocs = tenancy()->central(function () {
            return SharedDocument::query()
                ->select(['title', 'file_name', 'url'])
                ->selectRaw('true as shared')
                ->get();
        });
        $docs = DealerDoc::all();

        return view('livewire.dealer.docs.index', [
            'docs' => $docs->toBase()->merge($sharedDocs)->sortBy('title'),
        ])->layout('components.dealer-app');
    }
}
