<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\ViolationStatements;

use App\Enums\ViolationStatementCategory;
use App\Models\ViolationStatement;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $category = '';
    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $statements = ViolationStatement::query()
            ->when($this->search, fn ($q) => $q->where('statement', 'like', '%'.$this->search.'%'))
            ->when($this->category, fn ($q) => $q->whereJsonContains('categories', $this->category))
            ->orderBy('statement')
            ->paginate(20);

        return view('livewire.central.violation-statements.index', [
            'statements' => $statements,
            'categories' => ViolationStatementCategory::cases(),
        ])->layout('layouts.app');
    }
}
