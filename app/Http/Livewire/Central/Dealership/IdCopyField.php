<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Illuminate\View\View;
use Livewire\Component;

class IdCopyField extends Component
{
    public Dealership $dealership;

    public function render(): View
    {
        return view('livewire.central.dealership.id-copy-field');
    }
}
