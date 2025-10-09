<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    public User $user;
    public $assignedPermissions;

    public function mount()
    {
        $this->assignedPermissions = $this->user->permissions->pluck('name')->toArray();
    }

    public function render()
    {
        return view('livewire.dealer.employee.permissions', [
            'permissions' => Permission::all(),
        ]);
    }
}
