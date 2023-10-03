<?php

namespace App\Http\Livewire\Dealer\Docs;

use App\Models\DealerDoc;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['saved' => '$refresh'];
    
    public function render()
    {
        return view('livewire.dealer.docs.index', [
            'docs' => DealerDoc::all()
        ])->layout('components.dealer-app');
    }
}
