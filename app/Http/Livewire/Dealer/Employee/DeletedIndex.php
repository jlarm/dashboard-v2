<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedIndex extends Component
{
    use WithPagination;

    public ?Store $store = null;
    protected $listeners = ['refresh-deleted' => '$refresh'];

    public function render(): View
    {
        if ($this->store instanceof Store) {
            $users = $this->store->users()->with('department')->onlyTrashed();
        } else {
            $users = User::with('department')->onlyTrashed();
        }

        return view('livewire.dealer.employee.deleted-index', [
            'users' => $users->get(),
        ])->layout('components.dealer-app');
    }
}
