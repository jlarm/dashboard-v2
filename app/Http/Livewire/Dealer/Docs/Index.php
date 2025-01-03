<?php

namespace App\Http\Livewire\Dealer\Docs;

use App\Models\DealerDoc;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['saved' => '$refresh'];

    public function render(): View
    {
        return view('livewire.dealer.docs.index', [
            'docs' => DealerDoc::all(),
        ])->layout('components.dealer-app');
    }
}
