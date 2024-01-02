<?php

namespace App\Http\Livewire\Central\Department;

use App\Models\Department;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['departmentCreated' => 'render'];

    public function render()
    {
        return view('livewire.central.department.index', [
            'departments' => Department::orderBy('name')->get(),
        ]);
    }
}
