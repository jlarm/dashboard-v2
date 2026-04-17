<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Filament\Notifications\Notification;
use Livewire\Component;

class Restore extends Component
{
    public User $user;

    public function restoreEmployee(): void
    {
        $this->user->restore();

        $this->dispatch('refresh-deleted');

        Notification::make()
            ->title('Employee Restored Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.employee.restore');
    }
}
