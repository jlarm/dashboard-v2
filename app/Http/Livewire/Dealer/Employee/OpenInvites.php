<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\Department;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * @property-read Builder $invites
 */
class OpenInvites extends Component
{
    use WithPagination;

    public $search = '';
    public string $filterByDepartment = '';
    public $selectPage = false;
    public $selectAll = false;
    public $selected = [];
    protected $listeners = ['refreshOpenInvites' => '$refresh'];

    public function sendInvite($inviteId): void
    {
        $invite = $this->findInvite($inviteId);
        $this->dispatchInvite($invite);
        $this->notifyInviteSent($invite->name);
    }

    public function sendSelectedInvites(): void
    {
        foreach ($this->selected as $inviteId) {
            $invite = $this->findInvite($inviteId);
            $this->dispatchInvite($invite);
        }

        $this->notifyInvitesSent();
        $this->resetSelection();
    }

    public function updatedSelectPage($value): void
    {
        $this->selected = $value ? $this->getInviteIds() : [];
    }

    public function getInvitesProperty()
    {
        return $this->getInvitesQuery()
            ->when($this->filterByDepartment, function ($query): void {
                $query->where('department_id', $this->filterByDepartment);
            })
            ->search('name', $this->search);
    }

    public function updatedSelected(): void
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function selectAll(): void
    {
        $this->selectAll = true;
    }

    public function getDepartmentIds(): array
    {
        return $this->getInvitesQuery()
            ->pluck('department_id')
            ->unique()
            ->toArray();
    }

    public function getDepartmentName(int $id): string
    {
        return Department::query()->where('id', $id)->first()->name;
    }

    public function getStoreNames(array $stores): string
    {
        return Store::query()->whereIn('id', $stores)->pluck('name')->implode(', ');
    }

    public function clearFilters(): void
    {
        $this->filterByDepartment = '';
        $this->search = '';
    }

    public function render(): View
    {
        if ($this->selectAll) {
            $this->selected = $this->getInviteIds();
        }

        $invites = $this->applyManagerFilter($this->invites)->paginate(25);

        $departmentIds = $this->getDepartmentIds();

        $allDeptIds = array_unique(array_merge(
            $departmentIds,
            $invites->pluck('department_id')->filter()->all()
        ));

        $departmentNames = Department::query()
            ->whereIn('id', $allDeptIds)
            ->pluck('name', 'id');

        $allStoreIds = $invites
            ->flatMap(fn ($invite): array => (array) ($invite->stores ?? []))
            ->unique()
            ->values()
            ->all();

        $storeNameMap = $allStoreIds
            ? Store::query()->whereIn('id', $allStoreIds)->pluck('name', 'id')
            : collect();

        return view('livewire.dealer.employee.open-invites', [
            'invites' => $invites,
            'departmentIds' => $departmentIds,
            'departmentNames' => $departmentNames,
            'storeNameMap' => $storeNameMap,
        ]);
    }

    private function getInvitesQuery()
    {
        $query = Invite::query()
            ->whereNull('registered_at')
            ->with(['user', 'store'])
            ->orderByDesc('created_at');

        if (! app('multipleStoresExist')) {
            return $query;
        }

        $storeIds = $this->resolveScopedStoreIds();

        if ($storeIds->isEmpty()) {
            $query->whereRaw('1 = 0');

            return $query;
        }

        $query->where(function (Builder $query) use ($storeIds): void {
            foreach ($storeIds as $storeId) {
                $query->orWhereJsonContains('stores', (string) $storeId)
                    ->orWhereJsonContains('stores', (int) $storeId);
            }
        });

        return $query;
    }

    private function findInvite($inviteId)
    {
        return Invite::query()->findOrFail($inviteId);
    }

    private function dispatchInvite($invite): void
    {
        SendQueueEmailJob::dispatch($invite);
        $invite->touch();
    }

    private function notifyInviteSent($inviteName): void
    {
        Notification::make()
            ->title("Invite to {$inviteName} sent")
            ->success()
            ->send();

        $this->emit('refreshOpenInvites');
    }

    private function notifyInvitesSent(): void
    {
        Notification::make()
            ->title('Invites sent')
            ->success()
            ->send();

        $this->emit('refreshOpenInvites');
    }

    private function resetSelection(): void
    {
        $this->selectPage = false;
        $this->selected = [];
    }

    private function getInviteIds()
    {
        return $this->invites->pluck('id')->map(fn ($id): string => (string) $id);
    }

    private function applyManagerFilter($query)
    {
        if (auth()->user()->cannot('create-stores')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        return $query;
    }

    private function resolveScopedStoreIds(): Collection
    {
        if (app()->bound('scopedStoreIds')) {
            /** @var Collection $scopedStoreIds */
            $scopedStoreIds = app('scopedStoreIds');

            $normalizedScopedStoreIds = $scopedStoreIds->map(static fn ($id): int => (int) $id)->values();

            if ($normalizedScopedStoreIds->isNotEmpty()) {
                return $normalizedScopedStoreIds;
            }
        }

        $user = auth()->user();

        if (! $user) {
            return collect();
        }

        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return $user->current_store_id !== null
                ? collect([(int) $user->current_store_id])
                : Store::query()->pluck('id');
        }

        $assignedStoreIds = $user->stores()->pluck('stores.id')->map(static fn ($id): int => (int) $id);

        if ($user->current_store_id === null) {
            return $assignedStoreIds;
        }

        if ($assignedStoreIds->contains($user->current_store_id)) {
            return collect([(int) $user->current_store_id]);
        }

        return collect();
    }
}
