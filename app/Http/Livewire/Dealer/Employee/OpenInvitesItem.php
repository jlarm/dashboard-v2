<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use Filament\Notifications\Notification;
use Livewire\Component;
use App\Models\Dealer\Invite;

class OpenInvitesItem extends Component
{
    public Invite $invite;

    public function sendInvite()
    {
        SendQueueEmailJob::dispatch($this->invite);

        Notification::make()
            ->title('Invite to ' . $this->invite->name . ' sent')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.employee.open-invites-item');
    }
}
