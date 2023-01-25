<?php

namespace App\Http\Livewire\Central\Employee;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.central.employee.index', [
            'users' => User::orderBy('name')->with('roles')->get()
        ]);
    }
}
