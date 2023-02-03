<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Livewire\Component;

class Index extends Component
{
    public $search = '';

    protected $listeners = ['refreshDealerships' => '$refresh'];

    public function dashboardLink()
    {
    }

    public function render()
    {
        return view('livewire.central.dealership.index', [
            'dealerships' => Dealership::search('name', $this->search)->latest()->with('user')->get(),
        ]);
    }
}
