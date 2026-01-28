<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Livewire\Component;

class Checklist extends Component
{
    public Contract $contract;
    protected $listeners = ['contractUpdated' => '$refresh'];

    public function progress()
    {
        $progress = $this->contract->status->pluck('step')->toArray();
        $progress = array_unique($progress);

        return array_filter($progress, fn ($value) => $value !== null);
    }

    public function render()
    {
        return view('livewire.central.contracts.checklist');
    }
}
