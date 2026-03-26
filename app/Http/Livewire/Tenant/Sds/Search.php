<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Sds;

use App\Models\Sds;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'page' => ['except' => 1],
    ];

    public function mount(): void
    {
        $this->search ??= '';
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->sortField = 'name';
        $this->sortDirection = 'asc';
        $this->resetPage();
    }

    public function hasSearchCriteria(): bool
    {
        return ! in_array(mb_trim($this->search), ['', '0'], true);
    }

    public function render(): View
    {
        return tenancy()->central(function () {
            if (! $this->hasSearchCriteria()) {
                $sdsRecords = collect([]);
            } else {
                $query = Sds::query();

                if (! in_array(mb_trim($this->search), ['', '0'], true)) {
                    $searchTerm = mb_trim($this->search);
                    $query->where(function ($q) use ($searchTerm): void {
                        $q->where('name', 'like', '%'.$searchTerm.'%')
                            ->orWhere('manufacturer', 'like', '%'.$searchTerm.'%')
                            ->orWhere('keywords', 'like', '%'.$searchTerm.'%')
                            ->orWhere('file_name', 'like', '%'.$searchTerm.'%');
                    });
                }

                $query->orderBy($this->sortField, $this->sortDirection);

                if ($this->sortField !== 'name') {
                    $query->orderBy('name', 'asc');
                }

                $sdsRecords = $query->paginate(25);
            }

            return view('livewire.tenant.sds.search', [
                'sdsRecords' => $sdsRecords,
            ]);
        });
    }
}
