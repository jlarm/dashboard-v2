<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Sds;

use App\Models\Sds;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public Sds $sheet;

    public function render(): View
    {
        return view('livewire.central.sds.index-item');
    }
}
