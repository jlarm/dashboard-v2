<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Livewire\Component;

class IndexItem extends Component
{
    public Dealership $dealership;

    public function render()
    {
        return view('livewire.central.dealership.index-item');
    }
}
