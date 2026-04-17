<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class Index extends Component
{
    /** @var array<string, string> */
    #[Override]
    protected $listeners = ['contractDeleted' => '$refresh'];

    public function render(): View
    {
        return view('livewire.central.contracts.index', [
            'contracts' => $this->getContracts(),
        ]);
    }

    /**
     * @return Collection<int, Contract>
     */
    protected function getContracts(): Collection
    {
        if (auth()->user()?->hasRole('super-admin')) {
            return Contract::with(['user', 'status'])->get();
        }

        return Contract::with('status')->where('user_id', auth()->id())->get();
    }
}
