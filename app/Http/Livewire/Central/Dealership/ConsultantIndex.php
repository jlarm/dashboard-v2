<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Livewire\Component;

class ConsultantIndex extends Component
{
    public function render()
    {
        return view('livewire.central.dealership.consultant-index', [
            'dealerships' => Dealership::where('user_id', auth()->user()->id)->get(),
        ]);
    }
}
