<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class OpenInvites extends Component
{
    use WithPagination;

    public $search = '';
    public $selectPage = false;
    public $selectAll = false;
    public $selected = [];

    protected $listeners = ['refreshOpenInvites' => '$refresh'];

    public function sendInvite($inviteId)
    {
        $invite = $this->findInvite($inviteId);
        $this->dispatchInvite($invite);
        $this->notifyInviteSent($invite->name);
    }

    public function sendSelectedInvites()
    {
        foreach ($this->selected as $inviteId) {
            $invite = $this->findInvite($inviteId);
            $this->dispatchInvite($invite);
        }

        $this->notifyInvitesSent();
        $this->resetSelection();
    }

    public function updatedSelectPage($value)
    {
        $this->selected = $value ? $this->getInviteIds() : [];
    }

    public function getInvitesProperty()
    {
        return Invite::query()
            ->whereNull('registered_at')
            ->with(['user', 'store'])
            ->orderByDesc('created_at')
            ->search('name', $this->search);
    }

    public function updatedSelected()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
    }

    public function render()
    {
        if ($this->selectAll) {
            $this->selected = $this->getInviteIds();
        }

        $invites = $this->applyManagerFilter($this->invites)->paginate(25);

        return view('livewire.dealer.employee.open-invites', compact('invites'));
    }

    private function findInvite($inviteId)
    {
        return Invite::findOrFail($inviteId);
    }

    private function dispatchInvite($invite)
    {
        SendQueueEmailJob::dispatch($invite);
        $invite->touch();
    }

    private function notifyInviteSent($inviteName)
    {
        Notification::make()
            ->title("Invite to $inviteName sent")
            ->success()
            ->send();

        $this->emit('refreshOpenInvites');
    }

    private function notifyInvitesSent()
    {
        Notification::make()
            ->title('Invites sent')
            ->success()
            ->send();

        $this->emit('refreshOpenInvites');
    }

    private function resetSelection()
    {
        $this->selectPage = false;
        $this->selected = [];
    }

    private function getInviteIds()
    {
        return $this->invites->pluck('id')->map(fn($id) => (string) $id);
    }

    private function applyManagerFilter($query)
    {
        if (auth()->user()->hasRole('Manager')) {
            $query->where('department_id', auth()->user()->department_id);
        }
        return $query;
    }
}
