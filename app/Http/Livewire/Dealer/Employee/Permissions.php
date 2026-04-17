<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    public User $user;
    public $assignedPermissions;

    public function mount(): void
    {
        $this->assignedPermissions = $this->user->permissions->pluck('name')->toArray();
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.employee.permissions', [
            'permissions' => Permission::all(),
        ]);
    }
}
