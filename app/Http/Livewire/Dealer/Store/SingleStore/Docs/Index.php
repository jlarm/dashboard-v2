<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Docs;

use App\Models\Dealer\Store;
use App\Models\SharedDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public Store $store;
    protected $listeners = ['saved' => '$refresh'];

    public function download($doc)
    {
        return tenancy()->central(fn () => Storage::disk('public')->download($doc['file_name']));
    }

    public function render(): View
    {
        $sharedDocs = tenancy()->central(fn () => SharedDocument::query()
            ->select(['title', 'file_name', 'url'])
            ->selectRaw('true as shared')
            ->get());
        $docs = $this->store->docs;

        return view('livewire.dealer.store.single-store.docs.index', [
            'docs' => $docs->toBase()->merge($sharedDocs)->sortBy('title'),
        ])->layout('components.dealer-app');
    }
}
