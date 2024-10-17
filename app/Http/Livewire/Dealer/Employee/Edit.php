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
        $this->initializeUserData($user);
    }

    private function initializeUserData(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->assignedStores = $user->stores()->pluck('name')->toArray();
        $this->department = $user->department_id;
        $this->assignedRoles = $user->roles()->whereNotIn('name', ['Qualified Individual'])->pluck('name')->toArray();
        $this->qi = $this->user->hasRole('Qualified Individual');
        $this->qiCount = Role::find(5)->users()->count();
    }

    public function updateUser()
    {
        if (count($this->assignedRoles) > 1) {
            $this->sendNotification('Only one role can be assigned unless it includes "Qualified Individual".', 'warning');
            return;
        }

        $this->updateUserData();
        $this->syncUserRoles();
        $this->assignQiRole();
        $this->clearPermissionCache();
        $this->emitRefreshEvents();
        $this->closeWithSuccessNotification();
    }

    private function updateUserData()
    {
        $this->user->update([
            'department_id' => $this->department,
        ]);

        $this->user->stores()->sync(Store::whereIn('name', $this->assignedStores)->pluck('id')->toArray());
    }

    private function assignQiRole()
    {
        if ($this->qi) {
            $this->user->assignRole('Qualified Individual');
        } else {
            $this->user->removeRole('Qualified Individual');
        }
    }

    private function syncUserRoles()
    {
        $this->user->syncRoles($this->assignedRoles);
    }

    private function clearPermissionCache()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function emitRefreshEvents()
    {
        $this->emitTo('dealer.employee.details', 'refreshEmployeeDetails');
        $this->emitTo('dealer.employee.course-results', 'refreshEmployeeDetails');
    }

    private function closeWithSuccessNotification()
    {
        $this->close();
        $this->sendNotification($this->user->name . ' successfully updated', 'success');
    }

    private function sendNotification($message, $type)
    {
        Notification::make()
            ->title($message)
            ->{$type}()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.employee.edit', [
            'stores' => Store::all(),
            'departments' => Department::all(),
            'allRoles' => $this->getAvailableRoles(),
            'qiAvailable' => $this->isQiAvailable(),
        ]);
    }

    private function getAvailableRoles()
    {
        return Role::query()
            ->whereNotIn('name', ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'])
            ->orderBy('name')
            ->get();
    }

    private function isQiAvailable()
    {
        return User::role('Qualified Individual')->count() < 3 || $this->qi;
    }
}
