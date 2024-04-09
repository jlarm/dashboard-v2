<?php

namespace App\Http\Livewire\Central\Employee;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        return view('livewire.central.employee.index', [
            'users' => User::query()
                ->search('name', $this->search)
                ->orderBy('name')
                ->with(['roles', 'courses'])
                ->paginate(20),
        ]);
    }
}
