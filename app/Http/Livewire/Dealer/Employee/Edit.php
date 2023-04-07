<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use Filament\Notifications\Notification;
use Spatie\Permission\Models\Role;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Edit extends SlideOver
{
    public $user;

    public $name;

    public $role;

    public $stores = [];

    public $department;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->stores = $user->stores()->get();
        $this->department = $user->department_id;
        $this->role = $user->getRoleNames()->first();
    }

    public function updateUser()
    {
        $this->user->update([
            'department_id' => $this->department,
            'role' => $this->user->syncRoles($this->role),
        ]);

        $this->emitTo('dealer.employee.details', 'refreshEmployeeDetails');
        $this->emitTo('dealer.employee.course-results', 'refreshEmployeeDetails');

        $this->close();

        Notification::make()
            ->title($this->user->name.' successfully updated')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.employee.edit', [
            'stores' => Store::all(),
            'departments' => Department::all(),
            'roles' => Role::all(),
        ]);
    }
}
