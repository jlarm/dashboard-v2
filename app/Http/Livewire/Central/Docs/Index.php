<?php

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    public function render()
    {
        return view('livewire.central.docs.index')->layout('layouts.app');
    }
}
