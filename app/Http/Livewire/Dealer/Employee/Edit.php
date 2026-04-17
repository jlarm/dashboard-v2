<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Edit extends SlideOver
{
    private const array ROLE_PRIORITY = [
        'Owner' => 1,
        'GM' => 2,
        'CFO' => 3,
        'GSM' => 4,
        'Manager' => 5,
        'Employee' => 6,
        'Porter/Driver' => 7,
    ];

    public ?Store $store = null;
    public User $user;
    public string $name = '';
    public array $assignedStores = [];
    public ?int $primaryStoreId = null;
    public ?int $department = null;
    public string $assignedRole = '';
    public bool $qi = false;
    public int $qiCount = 0;
    public bool $remediationRemindersActive = false;
    public array $selectedAuditTypes = [];
    public bool $showStoreAssignment = false;

    public function mount(int $userId): void
    {
        $this->initializeUserData(User::query()->findOrFail($userId));
    }

    public function updatedAssignedStores(): void
    {
        if ($this->primaryStoreId !== null && ! in_array($this->primaryStoreId, $this->normalizedAssignedStoreIds(), true)) {
            $this->primaryStoreId = null;
        }
    }

    public function updateUser(): void
    {
        $this->validate();

        $this->updateUserData();
        $this->syncUserRoles();
        $this->assignQiRole();
        $this->clearPermissionCache();
        $this->updateCurrentStoreId();
        $this->updatePrimaryStoreId();
        $this->emitRefreshEvents();
        $this->closeWithSuccessNotification();
    }

    public function render(): View
    {
        $stores = Store::query()->orderBy('name')->get();

        return view('livewire.dealer.employee.edit', [
            'stores' => $stores,
            'departments' => Department::query()->orderBy('name')->get(),
            'allRoles' => $this->getAvailableRoles(),
        ]);
    }

    protected function rules(): array
    {
        $rules = [
            'department' => 'required|exists:departments,id',
            'assignedRole' => 'required|string',
        ];

        if ($this->shouldShowStoreAssignment()) {
            $rules['assignedStores'] = 'required|array';
            $rules['assignedStores.*'] = 'integer|exists:stores,id';

            if (count($this->normalizedAssignedStoreIds()) > 1) {
                $rules['primaryStoreId'] = 'required|integer|exists:stores,id';
            }
        }

        return $rules;
    }

    protected function messages(): array
    {
        $messages = [
            'department.required' => 'Please select a department.',
            'department.exists' => 'Please select a valid department.',
            'assignedRole.required' => 'Please select a role.',
        ];

        if ($this->shouldShowStoreAssignment()) {
            $messages['assignedStores.required'] = 'Please select at least one store.';
            $messages['primaryStoreId.required'] = 'Please select a primary store.';
        }

        return $messages;
    }

    private function initializeUserData(User $user): void
    {
        $this->store = (app()->bound('currentStoreModel') ? resolve('currentStoreModel') : null)
            ?? Store::query()->find(resolve('currentStore'));
        $this->user = $user;
        $this->name = $user->name;
        $this->assignedStores = $user->stores()->pluck('stores.id')->map(static fn ($id): int => (int) $id)->all();
        $this->primaryStoreId = $user->primary_store_id ? (int) $user->primary_store_id : null;
        $this->department = $user->department_id;
        $this->showStoreAssignment = $this->shouldShowStoreAssignment();

        $userRoles = $user->roles()->whereNotIn('name', ['Qualified Individual'])->pluck('name')->toArray();

        if (count($userRoles) > 1) {
            $this->assignedRole = $this->getHighestPriorityRole($userRoles);

            Notification::make()
                ->title('Multiple roles detected')
                ->body('This employee had multiple roles: '.implode(', ', $userRoles).". The highest priority role ({$this->assignedRole}) has been selected. Saving will remove the other roles.")
                ->warning()
                ->persistent()
                ->send();
        } else {
            $this->assignedRole = $userRoles[0] ?? '';
        }

        $this->qi = $this->user->hasRole('Qualified Individual');
        $this->qiCount = $this->getQualifiedIndividualRole()->users()->count();
        $this->selectedAuditTypes = $user->remediationReminderPreferences()->pluck('audit_type')->toArray();
        $this->remediationRemindersActive = $this->store?->remediationSettings()?->first()?->notifications ?? false;
    }

    private function getHighestPriorityRole(array $roles): string
    {
        usort($roles, function ($a, $b): int {
            $priorityA = self::ROLE_PRIORITY[$a] ?? 999;
            $priorityB = self::ROLE_PRIORITY[$b] ?? 999;

            return $priorityA <=> $priorityB;
        });

        return $roles[0] ?? '';
    }

    private function updateUserData(): void
    {
        $this->user->update([
            'department_id' => $this->department,
        ]);

        if ($this->showStoreAssignment) {
            $this->user->stores()->sync($this->normalizedAssignedStoreIds());
        }

        $this->user->remediationReminderPreferences()->delete();

        foreach ($this->selectedAuditTypes as $auditType) {
            $this->user->remediationReminderPreferences()->create([
                'audit_type' => $auditType,
                'enabled' => true,
            ]);
        }
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
        $this->user->syncRoles([$this->assignedRole]);
    }

    private function clearPermissionCache(): void
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function emitRefreshEvents(): void
    {
        $this->dispatch('refreshEmployeeDetails')->to('dealer.employee.details');
        $this->dispatch('refreshEmployeeDetails')->to('dealer.employee.course-results');
    }

    private function closeWithSuccessNotification(): void
    {
        $this->close();
        $this->sendNotification("{$this->user->name} successfully updated", 'success');
    }

    private function sendNotification(string $message, string $type): void
    {
        Notification::make()
            ->title($message)
            ->{$type}()
            ->send();
    }

    private function updateCurrentStoreId(): void
    {
        if (! $this->showStoreAssignment) {
            return;
        }

        $assignedStoreIds = $this->normalizedAssignedStoreIds();

        if ($assignedStoreIds === []) {
            return;
        }

        if (! in_array((int) $this->user->current_store_id, $assignedStoreIds, true)) {
            $this->user->update([
                'current_store_id' => count($assignedStoreIds) === 1 ? $assignedStoreIds[0] : null,
            ]);
        }
    }

    private function updatePrimaryStoreId(): void
    {
        if (! $this->showStoreAssignment) {
            return;
        }

        $assignedStoreIds = $this->normalizedAssignedStoreIds();

        if (count($assignedStoreIds) <= 1) {
            $this->user->update(['primary_store_id' => null]);

            return;
        }

        if ($this->primaryStoreId !== null && in_array($this->primaryStoreId, $assignedStoreIds, true)) {
            $this->user->update(['primary_store_id' => $this->primaryStoreId]);
        }
    }

    private function shouldShowStoreAssignment(): bool
    {
        return Store::query()->count() > 1;
    }

    /**
     * @return array<int, int>
     */
    private function normalizedAssignedStoreIds(): array
    {
        return collect($this->assignedStores)
            ->map(static fn ($storeId): int => (int) $storeId)
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function getAvailableRoles(): Collection
    {
        return Role::query()
            ->whereNotIn('name', ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'])
            ->orderBy('name')
            ->get();
    }

    private function getQualifiedIndividualRole(): Role
    {
        return Role::query()->where('name', 'Qualified Individual')->firstOrFail();
    }
}
