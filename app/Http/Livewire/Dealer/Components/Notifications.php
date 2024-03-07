<?php

namespace App\Http\Livewire\Dealer\Components;

use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class Notifications extends Component
{
    protected $listeners = ['notification' => '$refresh'];

    public function markAsRead($notification): void
    {
        DatabaseNotification::find($notification['id'])->delete();

        $this->emit('notification');
    }

    public function markAllAsRead(): void
    {
        auth()->user()->notifications->each->delete();

        $this->emit('notification');
    }

    public function render()
    {
        return view('livewire.dealer.components.notifications');
    }
}
