<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['refreshDealerships' => '$refresh'];
    public function render()
    {
        return view('livewire.central.dealership.index', [
            'dealerships' => Dealership::latest()->with('user')->get(),
        ]);
    }
}
