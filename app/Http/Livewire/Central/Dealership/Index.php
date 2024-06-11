<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['refreshDealerships' => '$refresh'];

    public function updatedSearch($value)
    {
        $this->resetPage();
    }

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
                ->paginate(10),
        ]);
    }
}
