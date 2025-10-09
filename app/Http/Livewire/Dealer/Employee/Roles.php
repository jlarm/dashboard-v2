<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    public User $user;
    public $assignedRoles;

    public function mount()
    {
        $this->assignedRoles = $this->user->roles->pluck('name')->toArray();
    }

    public function render()
    {
        return view('livewire.dealer.employee.roles', [
            'roles' => Role::whereNot('name', 'super-admin')
                ->whereNot('name', 'Admin')
                ->whereNot('name', 'Consultant')
                ->orderBy('name', 'asc')
                ->get(),
        ]);
    }
}
