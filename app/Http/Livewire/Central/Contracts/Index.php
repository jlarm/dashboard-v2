<?php

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.central.contracts.index', [
            'contracts' => Contract::all(),
        ]);
    }
}
