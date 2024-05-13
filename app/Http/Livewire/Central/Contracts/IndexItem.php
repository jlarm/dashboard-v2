<?php

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Livewire\Component;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class IndexItem extends Component
{
    use InteractsWithConfirmationModal;

    public Contract $contract;

    public function progress()
    {
        $progress = $this->contract->status->pluck('step')->toArray();
        $progress = array_unique($progress);

        $progress = array_filter($progress, function ($value) {
            return $value !== null;
        });

        return end($progress);
    }

    public function render()
    {
        return view('livewire.central.contracts.index-item');
    }
}
