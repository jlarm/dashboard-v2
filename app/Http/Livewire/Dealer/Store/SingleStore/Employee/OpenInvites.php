<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class OpenInvites extends Component
{
    use WithPagination;

    public Store $store;
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
        $this->selectPage = false;
        $this->resetSelection();
    }

    public function updatedSelectPage($value)
    {
        $this->selected = $value ? $this->getInviteIds() : [];
    }

    public function getInvitesProperty()
    {
        return Invite::query()
            ->whereJsonContains('stores', (string) $this->store->id)
            ->whereNull('registered_at')
            ->with('user')
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

        return view('livewire.dealer.store.single-store.employee.open-invites', [
            'invites' => $this->invites->paginate(25),
        ])->layout('components.dealer-app');
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
        $this->selectAll = false; // Ensure selectAll is also reset
        $this->selected = [];
    }

    private function getInviteIds()
    {
        return $this->invites->pluck('id')->map(fn($id) => (string) $id);
    }
}
