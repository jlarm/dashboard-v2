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

    public $assignedStores;

    public $department;

    public $assignedRoles;

    public $qiCount;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->assignedStores = $user->stores()->pluck('name')->toArray();
        $this->department = $user->department_id;
        $this->assignedRoles = $user->getRoleNames()->toArray();
        $this->qiCount = Role::find(5)->users()->count();
    }

    public function updateUser()
    {
        $this->user->update([
            'department_id' => $this->department,
        ]);

        $this->user->stores()->sync(Store::whereIn('name', $this->assignedStores)->pluck('id')->toArray());

        $this->user->syncRoles($this->assignedRoles);

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

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
            'allRoles' => Role::whereNot('name', 'super-admin')
                ->whereNot('name', 'Admin')
                ->whereNot('name', 'Consultant')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
