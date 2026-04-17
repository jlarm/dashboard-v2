<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;
use Override;

class Notifications extends Component
{
    #[Override]
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

    public function render(): Factory|View
    {
        return view('livewire.dealer.components.notifications');
    }
}
