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

    public $qi;

    public $qiCount;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->assignedStores = $user->stores()->pluck('name')->toArray();
        $this->department = $user->department_id;
        $this->assignedRoles = $user->getRoleNames()->toArray();
        $this->qi = $this->user->hasRole('Qualified Individual');
        $this->qiCount = Role::find(5)->users()->count();
    }

    public function updateUser()
    {
        // Ensure at least one role is assigned
        if (empty($this->assignedRoles)) {
            Notification::make()
                ->title('At least one role must be assigned.')
                ->warning()
                ->send();

            return;
        }

        // Ensure at least one store is selected
        if (empty($this->assignedStores)) {
            Notification::make()
                ->title('At least one store must be selected.')
                ->warning()
                ->send();

            return;
        }

        $this->user->update([
            'department_id' => $this->department,
        ]);

        $this->user->stores()->sync(Store::whereIn('name', $this->assignedStores)->pluck('id')->toArray());

        if ($this->qi) {
            if (! in_array('Qualified Individual', $this->assignedRoles)) {
                $this->assignedRoles[] = 'Qualified Individual';
            }
        } else {
            $key = array_search('Qualified Individual', $this->assignedRoles);
            if ($key !== false) {
                unset($this->assignedRoles[$key]);
            }
        }

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
        $rolesQuery = Role::query()
            ->whereNotIn('name', ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'])
            ->orderBy('name');

        return view('livewire.dealer.employee.edit', [
            'stores' => Store::all(),
            'departments' => Department::all(),
            'allRoles' => $rolesQuery->get(),
            'qiAvailable' => User::role('Qualified Individual')->count() < 3 || $this->qi,
        ]);
    }
}
