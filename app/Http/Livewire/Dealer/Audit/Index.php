<?php

namespace App\Http\Livewire\Dealer\Audit;

use App\Models\Dealer\Audit;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.dealer.audit.index', [
            'audits' => Audit::latest()->get()
        ]);
    }
}
