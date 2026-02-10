<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * @property-read Builder $invites
 */
class OpenInvites extends Component
{
    use WithPagination;

    public Store $store;
    public string $search = '';
    public string $filterByDepartment = '';
    public bool $selectPage = false;
    public bool $selectAll = false;
    public array $selected = [];
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
        $this->selectPage = false;
        $this->resetSelection();
    }

    public function updatedSelectPage($value): void
    {
        $this->selected = $value ? $this->getInviteIds() : [];
    }

    public function getInvitesProperty()
    {
        return $this->getInvitesQuery()
            ->orderByDesc('created_at')
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

        return view('livewire.dealer.store.single-store.employee.open-invites', [
            'invites' => $invites,
        ])->layout('components.dealer-app');
    }

    private function getInvitesQuery()
    {
        return Invite::query()
            ->whereNull('registered_at')
            ->whereJsonContains('stores', (string) $this->store->id)
            ->with(['user', 'store'])
            ->orderByDesc('created_at');
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
        $this->selectAll = false; // Ensure selectAll is also reset
        $this->selected = [];
    }

    private function getInviteIds()
    {
        return $this->invites->pluck('id')->map(fn ($id): string => (string) $id)->toArray();
    }

    private function applyManagerFilter($query)
    {
        if (auth()->user()->cannot('create-stores')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        return $query;
    }
}
