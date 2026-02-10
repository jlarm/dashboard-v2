<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Employee;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render(): View
    {
        return view('livewire.central.employee.index', [
            'users' => $this->getUsers(),
        ]);
    }

    private function getUsers()
    {
        return User::query()
            ->search('name', $this->search)
            ->orderBy('name')
            ->with(['roles'])
            ->paginate(20);
    }
}
