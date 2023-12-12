<?php

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['saved' => '$refresh'];

    public function render()
    {
        return view('livewire.central.docs.index', [
            'docs' => Document::orderBy('title')->get()
        ])->layout('layouts.app');
    }
}
