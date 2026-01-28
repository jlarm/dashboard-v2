<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\SharedDocs;

use App\Models\SharedDocument;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['deletedSharedDocument', '$refresh'];

    public function render(): View
    {
        return view('livewire.central.shared-docs.index', [
            'docs' => SharedDocument::query()
                ->orderBy('title')
                ->paginate(20),
        ]);
    }
}
