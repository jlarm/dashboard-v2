<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite as DealerInvite;
use App\Models\Dealer\Store;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use WireElements\Pro\Components\Modal\Modal;

class Invite extends Modal
{
    public string $name = '';
    public string $email = '';
    public string $department = '';
    public string $role = '';
    public array $stores = [];

    public function sendInvite(): void
    {
        $validated = $this->validate();
        $assignedStoreIds = $this->resolveAssignedStoreIds($validated['stores'] ?? []);

        $invite = DealerInvite::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'stores' => $assignedStoreIds,
            'department_id' => $this->department,
            'roles' => [$this->role],
            'user_id' => auth()->user()->id,
            'invitation_token' => mb_substr(md5(random_int(0, 9).$this->email.time()), 0, 32),
        ]);

        SendQueueEmailJob::dispatch($invite);

        $this->close();

        Notification::make()
            ->title('Invite Successfully Sent!')
            ->success()
            ->send();
    }

    public function render()
    {
        $qualifiedIndividualCount = User::role('Qualified Individual')->count();

        $rolesQuery = Role::query()->whereNot('name', 'super-admin')
            ->whereNot('name', 'Admin')
            ->whereNot('name', 'Consultant')
            ->orderBy('name');

        if ($qualifiedIndividualCount >= 2) {
            $rolesQuery->whereNot('name', 'Qualified Individual');
        }

        $availableStores = $this->availableStores();

        return view('livewire.dealer.employee.invite', [
            'allStore' => $availableStores,
            'departments' => Department::query()->orderBy('name')->get(),
            'allRoles' => $rolesQuery->get(),
        ]);
    }

    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'unique:invites', 'max:255'],
            'stores' => ['nullable', 'array'],
            'department' => ['required', 'integer', Rule::exists('departments', 'id')],
            'role' => ['required'],
        ];

        if ($this->availableStores()->count() > 1) {
            $rules['stores'] = ['required', 'array', 'min:1'];
            $rules['stores.*'] = ['integer', Rule::exists('stores', 'id')];
        }

        return $rules;
    }

    private function resolveAssignedStoreIds(array $selectedStores): array
    {
        $availableStoreIds = $this->availableStores()
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        if ($availableStoreIds->count() === 1) {
            $singleStoreId = $availableStoreIds->first();

            return $singleStoreId === null ? [] : [(int) $singleStoreId];
        }

        return collect($selectedStores)
            ->map(static fn ($storeId): int => (int) $storeId)
            ->filter(fn (int $storeId): bool => $availableStoreIds->contains($storeId))
            ->values()
            ->all();
    }

    /**
     * @return Collection<int, Store>
     */
    private function availableStores(): Collection
    {
        $user = auth()->user();

        if (! $user instanceof User) {
            return Store::query()->orderBy('name')->get(['id', 'name']);
        }

        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return Store::query()->orderBy('name')->get(['id', 'name']);
        }

        return $user->stores()->orderBy('stores.name')->get(['stores.id', 'stores.name']);
    }
}
