<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 12;

    protected $listeners = [
        'refreshDealerships' => '$refresh',
        'deleteDealership' => 'deleteDealership',
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function deleteDealership(string $dealershipId): void
    {
        if (! App::environment('local')) {
            session()->flash('error', 'Dealership deletion is disabled in production');

            return;
        }

        try {
            $dealership = Dealership::findOrFail($dealershipId);
            $dealership->delete();

            session()->flash('success', 'Dealership deleted successfully');
        } catch (\Exception $e) {
            session()->flash('error', "Failed to delete dealership: {$e->getMessage()}");
        }
    }

    public function render(): View
    {
        $dealerships = $this->getDealerships()
            ->orderBy('name')
            ->search('name', $this->search)
            ->with('users')
            ->paginate($this->perPage);

        return view('livewire.central.dealership.index', [
            'dealerships' => $dealerships,
        ]);
    }

    private function getDealerships()
    {
        return auth()->user()->hasRole('super-admin')
            ? Dealership::query()
            : auth()->user()->dealerships()->orWhere('id', 'e44653a5-c049-4be0-92e3-b8aacea4bf20');
    }
}
