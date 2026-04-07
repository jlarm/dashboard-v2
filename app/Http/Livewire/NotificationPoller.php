<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class NotificationPoller extends Component
{
    public string $since;

    public function mount(): void
    {
        $this->since = now()->toISOString();
    }

    public function poll(): void
    {
        $user = auth()->user();

        if (! $user instanceof User) {
            return;
        }

        $notifications = $user->unreadNotifications()
            ->where('data->format', 'filament')
            ->where('created_at', '>', $this->since)
            ->get();

        foreach ($notifications as $notification) {
            $this->emit('notificationSent', $notification->data);
        }

        $this->since = now()->toISOString();
    }

    public function render(): View
    {
        return view('livewire.notification-poller');
    }
}
