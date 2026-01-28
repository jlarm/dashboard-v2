<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    protected $listeners = ['saved' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        return view('livewire.central.docs.index', [
            'docs' => Document::query()
                ->orderBy('title')
                ->search('title', $this->search)
                ->paginate(20),
        ])->layout('layouts.app');
    }
}
