<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
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

    public function mount(User $user): void
    {
        $this->initializeUserData($user);
    }

    protected function rules(): array
    {
        $rules = [
            'department' => 'required|exists:departments,id',
            'assignedRoles' => 'required|array',
        ];

        if (tenant('locations')) {
            $rules['assignedStores'] = 'required|array';
        }

        return $rules;
    }

    protected function messages(): array
    {
        $messages = [
            'department.required' => 'Please select a department.',
            'department.exists' => 'Please select a valid department.',
            'assignedRoles.required' => 'Please select at least one role.',
        ];

        if (tenant('locations')) {
            $messages['assignedStores.required'] = 'Please select at least one store.';
        }

        return $messages;
    }

    private function initializeUserData(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->assignedStores = $user->stores()->pluck('name')->toArray();
        $this->department = $user->department_id;
        $this->assignedRoles = $user->roles()->whereNotIn('name', ['Qualified Individual'])->pluck('name')->toArray();
        $this->qi = $this->user->hasRole('Qualified Individual');
        $this->qiCount = Role::find(5)->users()->count();
    }

    public function updateUser(): void
    {
        $this->validate();

        $this->updateUserData();
        $this->syncUserRoles();
        $this->assignQiRole();
        $this->clearPermissionCache();
        $this->updateCurrentStoreId();
        $this->emitRefreshEvents();
        $this->closeWithSuccessNotification();
    }

    private function updateUserData(): void
    {
        $this->user->update([
            'department_id' => $this->department,
        ]);

        $this->user->stores()->sync(Store::whereIn('name', $this->assignedStores)->pluck('id')->toArray());
    }

    private function assignQiRole(): void
    {
        if ($this->qi) {
            $this->user->assignRole('Qualified Individual');
        } else {
            $this->user->removeRole('Qualified Individual');
        }
    }

    private function syncUserRoles(): void
    {
        $this->user->syncRoles($this->assignedRoles);
    }

    private function clearPermissionCache(): void
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function emitRefreshEvents(): void
    {
        $this->emitTo('dealer.employee.details', 'refreshEmployeeDetails');
        $this->emitTo('dealer.employee.course-results', 'refreshEmployeeDetails');
    }

    private function closeWithSuccessNotification(): void
    {
        $this->close();
        $this->sendNotification($this->user->name.' successfully updated', 'success');
    }

    private function sendNotification($message, $type): void
    {
        Notification::make()
            ->title($message)
            ->{$type}()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.employee.edit', [
            'stores' => Store::all(),
            'departments' => Department::all(),
            'allRoles' => $this->getAvailableRoles(),
        ]);
    }

    private function updateCurrentStoreId(): void
    {
        if (tenant('locations') && ! in_array($this->user->current_store_id, $this->assignedStores)) {
            $storeId = Store::where('name', $this->assignedStores[0])->first()->id;

            $this->user->update([
                'current_store_id' => $storeId,
            ]);
        }
    }

    private function getAvailableRoles()
    {
        return Role::query()
            ->whereNotIn('name', ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'])
            ->orderBy('name')
            ->get();
    }
}
