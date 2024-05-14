<?php

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['contractDeleted' => '$refresh'];

    protected function getContracts()
    {
        if (auth()->user()->hasRole('super-admin')) {
            return Contract::with('user')->get();
        }
        return Contract::where('user_id', auth()->id())->get();
    }
    public function render()
    {
        return view('livewire.central.contracts.index', [
            'contracts' => $this->getContracts(),
        ]);
    }
}
