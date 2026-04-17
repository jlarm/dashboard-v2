<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Override;

class Checklist extends Component
{
    public Contract $contract;

    #[Override]
    protected $listeners = ['contractUpdated' => '$refresh'];

    public function progress(): array
    {
        $progress = $this->contract->status->pluck('step')->toArray();
        $progress = array_unique($progress);

        return array_filter($progress, fn ($value): bool => $value !== null);
    }

    public function render(): Factory|View
    {
        return view('livewire.central.contracts.checklist');
    }
}
