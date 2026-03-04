<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use WireElements\Pro\Components\Modal\Modal;

class ManagerInvite extends Modal
{
    public string $name = '';
    public string $email = '';
    public string $role = '';
    public array $stores = [];

    public function create(): void
    {
        $validated = $this->validate();
        $assignedStoreIds = $this->resolveAssignedStoreIds($validated['stores'] ?? []);

        $invite = Invite::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'stores' => $assignedStoreIds,
            'department_id' => auth()->user()->department_id,
            'roles' => [$this->role],
            'user_id' => auth()->user()->id,
            'invitation_token' => mb_substr(md5(random_int(0, 9).$this->email.time()), 0, 32),
        ]);

        SendQueueEmailJob::dispatch($invite);

        Notification::make()
            ->title('Invite Successfully Sent!')
            ->success()
            ->send();

        $this->close();
    }

    public function render()
    {
        return view('livewire.dealer.employee.manager-invite', [
            'allStore' => $this->availableStores(),
        ]);
    }

    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'unique:invites', 'max:255'],
            'role' => ['required'],
            'stores' => ['nullable', 'array'],
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
