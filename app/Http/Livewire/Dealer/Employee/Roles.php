<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    public User $user;
    public $assignedRoles;

    public function mount(): void
    {
        $this->assignedRoles = $this->user->roles->pluck('name')->toArray();
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.employee.roles', [
            'roles' => Role::query()->whereNot('name', 'super-admin')
                ->whereNot('name', 'Admin')
                ->whereNot('name', 'Consultant')
                ->orderBy('name', 'asc')
                ->get(),
        ]);
    }
}
