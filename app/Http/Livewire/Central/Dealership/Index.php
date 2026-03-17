<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 25;
    protected $listeners = [
        'refreshDealerships' => '$refresh',
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        abort_unless(in_array($this->perPage, [10, 25, 50], true), 422);
        $this->resetPage();
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

    private function getDealerships(): Builder
    {
        if (auth()->user()->hasRole('super-admin')) {
            return Dealership::query();
        }

        return Dealership::query()
            ->whereHas('users', function (Builder $query): void {
                $query->where('user_id', auth()->id());
            })
            ->orWhere('id', config('dashboard.default_dealership_id'));
    }
}
