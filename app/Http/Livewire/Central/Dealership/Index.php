<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Livewire\Component;

class Index extends Component
{
    public $search = '';

    protected $listeners = ['refreshDealerships' => '$refresh'];

    private function query()
    {
        return auth()->user()->hasRole('super-admin')
            ? Dealership::query()
            : Dealership::query()->where('user_id', auth()->id())->orWhere('id', 'e44653a5-c049-4be0-92e3-b8aacea4bf20');
    }

    public function render()
    {
        return view('livewire.central.dealership.index', [
            'dealerships' => $this->query()
                ->orderBy('name')
                ->search('name', $this->search)
                ->with('user')
                ->get(),
        ]);
    }
}
