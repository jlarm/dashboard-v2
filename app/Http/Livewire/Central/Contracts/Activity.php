<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Livewire\Component;

class Activity extends Component
{
    public Contract $contract;
    protected $listeners = ['contractUpdated' => '$refresh'];

    public function render()
    {
        return view('livewire.central.contracts.activity', [
            'progress' => $this->contract->status,
        ]);
    }
}
