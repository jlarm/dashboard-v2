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
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Invite extends SlideOver
{
    public string $name = '';
    public string $email = '';
    public string $department = '';
    public string $role = '';
    public array $stores = [];
    public ?int $primaryStoreId = null;
    private ?Collection $memoizedAvailableStores = null;

    public function sendInvite(): void
    {
        $validated = $this->validate();
        $assignedStoreIds = $this->resolveAssignedStoreIds($validated['stores'] ?? []);

        $invite = DealerInvite::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'stores' => $assignedStoreIds,
            'primary_store_id' => count($assignedStoreIds) > 1 ? $this->primaryStoreId : null,
            'department_id' => $this->department,
            'roles' => [$this->role],
            'user_id' => auth()->id(),
            'invitation_token' => Str::random(32),
        ]);

        dispatch(new SendQueueEmailJob($invite));

        $this->close();

        Notification::make()
            ->title('Invite Successfully Sent!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        $qualifiedIndividualCount = User::query()->role('Qualified Individual')->count();

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
            'role' => ['required', Rule::exists('roles', 'name')],
        ];

        if ($this->availableStores()->count() > 1) {
            $rules['stores'] = ['required', 'array', 'min:1'];
            $rules['stores.*'] = ['integer', Rule::exists('stores', 'id')];

            if (count($this->stores) > 1) {
                $rules['primaryStoreId'] = ['required', 'integer', Rule::exists('stores', 'id')];
            }
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
        if ($this->memoizedAvailableStores instanceof Collection) {
            return $this->memoizedAvailableStores;
        }

        $user = auth()->user();

        if (! $user instanceof User) {
            return $this->memoizedAvailableStores = Store::query()->orderBy('name')->get(['id', 'name']);
        }

        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return $this->memoizedAvailableStores = Store::query()->orderBy('name')->get(['id', 'name']);
        }

        return $this->memoizedAvailableStores = $user->stores()->orderBy('stores.name')->get(['stores.id', 'stores.name']);
    }
}
