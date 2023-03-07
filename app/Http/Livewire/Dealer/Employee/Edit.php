<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\Models\Role;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Edit extends SlideOver
{
    public $user;

    public $name;

    public $role;

    public $store;

    public $department;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->store = $user->store_id;
        $this->department = $user->department_id;
        $this->role = $user->role;
    }

    public function updateUser()
    {
        $this->user->update([
            'store_id' => $this->store,
            'department_id' => $this->department,
            'role' => $this->role,
        ]);

        $this->emitTo('dealer.employee.details', 'refreshEmployeeDetails');
        $this->emitTo('dealer.employee.course-results', 'refreshEmployeeDetails');

        $this->close();
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
