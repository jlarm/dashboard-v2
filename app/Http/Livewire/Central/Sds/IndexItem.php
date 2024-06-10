<?php

namespace App\Http\Livewire\Central\Sds;

use App\Models\Sds;
use Livewire\Component;

class IndexItem extends Component
{
    public Sds $sheet;

    public function render()
    {
        return view('livewire.central.sds.index-item');
    }
}
