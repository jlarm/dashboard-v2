<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Components;

use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class Notifications extends Component
{
    protected $listeners = ['notification' => '$refresh'];

    public function markAsRead(array $notification): void
    {
        DatabaseNotification::query()->find($notification['id'])?->delete();

        $this->dispatch('notification');
    }

    public function markAllAsRead(): void
    {
        auth()->user()->notifications->each->delete();

        $this->dispatch('notification');
    }

    public function render()
    {
        return view('livewire.dealer.components.notifications');
    }
}
