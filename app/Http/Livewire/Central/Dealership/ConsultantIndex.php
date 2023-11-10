<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Livewire\Component;

class ConsultantIndex extends Component
{
    protected $listeners = ['refreshDealerships' => '$refresh'];

    public function render()
    {
        return view('livewire.central.dealership.consultant-index', [
            'dealerships' => Dealership::query()
                ->where('user_id', auth()->user()->id)
                ->orWhere('id', 'e44653a5-c049-4be0-92e3-b8aacea4bf20')
                ->get(),
        ]);
    }
}
