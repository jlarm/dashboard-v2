<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Override;

class DeletedIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?Store $store = null;

    #[Override]
    protected $listeners = ['refresh-deleted' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render(): View
    {
        if ($this->store instanceof Store) {
            $users = $this->store->users()->with('department')->onlyTrashed();
        } else {
            $users = User::with('department')->onlyTrashed();
        }

        if ($this->search !== '' && $this->search !== '0') {
            $search = $this->search;

            $users->where(function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return view('livewire.dealer.employee.deleted-index', [
            'users' => $users
                ->orderByDesc('deleted_at')
                ->orderByDesc('id')
                ->paginate(15),
        ])->layout('components.dealer-app');
    }
}
