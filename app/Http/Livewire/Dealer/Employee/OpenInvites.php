<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\Department;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

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
            ->when($this->filterByDepartment, function ($query) {
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
        return Department::where('id', $id)->first()->name;
    }

    public function getStoreNames(array $stores): string
    {
        return Store::whereIn('id', $stores)->pluck('name')->implode(', ');
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

        return view('livewire.dealer.employee.open-invites', [
            'invites' => $invites,
        ]);
    }

    private function getInvitesQuery()
    {
        return Invite::query()
            ->whereNull('registered_at')
            ->with(['user', 'store'])
            ->orderByDesc('created_at');
    }

    private function findInvite($inviteId)
    {
        return Invite::findOrFail($inviteId);
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
        return $this->invites->pluck('id')->map(fn ($id) => (string) $id);
    }

    private function applyManagerFilter($query)
    {
        if (auth()->user()->cannot('create-stores')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        return $query;
    }
}
