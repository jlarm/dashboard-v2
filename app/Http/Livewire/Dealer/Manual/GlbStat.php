<?php

namespace App\Http\Livewire\Dealer\Manual;

use App\Models\Dealer\Manual\Glb;
use Livewire\Component;

class GlbStat extends Component
{
    public function render()
    {
        return view('livewire.dealer.manual.glb-stat', [
            'manual' => Glb::latest()->first(),
        ]);
    }
}
