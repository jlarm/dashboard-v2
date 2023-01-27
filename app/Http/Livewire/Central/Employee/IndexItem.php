<?php

namespace App\Http\Livewire\Central\Employee;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class IndexItem extends Component
{
    public User $user;
    public function render()
    {
        return view('livewire.central.employee.index-item');
    }
}
