<?php

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Livewire\Component;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class IndexItem extends Component
{
    use InteractsWithConfirmationModal;

    public Contract $contract;

    public function render()
    {
        return view('livewire.central.contracts.index-item');
    }
}
