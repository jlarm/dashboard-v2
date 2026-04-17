<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OpenInvitesItem extends Component
{
    public Invite $invite;

    public function sendInvite(): void
    {
        dispatch(new SendQueueEmailJob($this->invite));

        Notification::make()
            ->title('Invite to '.$this->invite->name.' sent')
            ->success()
            ->send();
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.employee.open-invites-item');
    }
}
