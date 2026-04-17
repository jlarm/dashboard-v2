<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Override;

class Activity extends Component
{
    public Contract $contract;

    #[Override]
    protected $listeners = ['contractUpdated' => '$refresh'];

    public function render(): Factory|View
    {
        return view('livewire.central.contracts.activity', [
            'progress' => $this->contract->status,
        ]);
    }
}
