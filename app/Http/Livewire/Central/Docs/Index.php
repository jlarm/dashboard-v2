<?php

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['saved' => '$refresh'];

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.central.docs.index', [
//            'docs' => Document::query()
//                ->orderBy('title')
//                ->search('title', $this->search)
//                ->paginate(10)
        ])->layout('layouts.app');
    }
}
