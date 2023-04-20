<?php

namespace App\Http\Livewire\Dealer\Audit;

use App\Models\Dealer\Audit;
use Livewire\Component;

class Show extends Component
{
    public Audit $audit;
    public function render()
    {
        return view('livewire.dealer.audit.show');
    }
}
