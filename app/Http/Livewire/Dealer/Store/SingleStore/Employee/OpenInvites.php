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

    public function sendInvite($invite)
    {
        $invite = Invite::findOrFail($invite);

        SendQueueEmailJob::dispatch($invite);

        Notification::make()
            ->title('Invite to '.$invite->name.' sent')
            ->success()
            ->send();
    }

    public function sendSelectedInvites()
    {
        foreach ($this->selected as $invite) {
            $invite = Invite::findOrFail($invite);
            SendQueueEmailJob::dispatch($invite);
        }

        Notification::make()
            ->title('Invites sent')
            ->success()
            ->send();

        $this->selected = [];
    }

    public function updatedSelectPage($value)
    {
        $this->selected = $value ? $this->invites->pluck('id')->map(fn ($id) => (string) $id) : [];
    }

    public function getInvitesProperty()
    {
        return Invite::query()
            ->whereJsonContains('stores', (string) $this->store->id)
            ->where('registered_at', null)
            ->with('user')
            ->orderBy('created_at', 'desc')
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
            $this->selected = $this->invites->pluck('id')->map(fn ($id) => (string) $id);
        }

        return view('livewire.dealer.store.single-store.employee.open-invites', [
            'invites' => $this->invites->paginate(25),
        ])->layout('components.dealer-app');
    }
}
