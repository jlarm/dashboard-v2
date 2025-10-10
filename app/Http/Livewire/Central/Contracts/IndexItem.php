<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Illuminate\View\View;
use Livewire\Component;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class IndexItem extends Component
{
    use InteractsWithConfirmationModal;

    public Contract $contract;

    public function progress(): mixed
    {
        $progress = $this->contract->status->pluck('step')->toArray();
        $progress = array_unique($progress);

        $progress = array_filter($progress, static fn ($value): bool => $value !== null);

        return end($progress);
    }

    public function render(): View
    {
        return view('livewire.central.contracts.index-item');
    }
}
