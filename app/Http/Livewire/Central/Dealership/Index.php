<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public int $perPage = 12;

    protected $listeners = ['refreshDealerships' => 'query'];

    public function updatedSearch($value): void
    {
        $this->resetPage();
    }

    private function query()
    {
        return auth()->user()->hasRole('super-admin')
            ? Dealership::query()
            : auth()->user()->dealerships()->orWhere('id', 'e44653a5-c049-4be0-92e3-b8aacea4bf20');
    }

    public function render(): View
    {
        return view('livewire.central.dealership.index', [
            'dealerships' => $this->query()
                ->orderBy('name')
                ->search('name', $this->search)
                ->with('users')
                ->paginate($this->perPage),
        ]);
    }
}
