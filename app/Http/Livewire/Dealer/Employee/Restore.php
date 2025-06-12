<?php

namespace App\Http\Livewire\Dealer\Employee;

use Livewire\Component;
use App\Models\User;
use Filament\Notifications\Notification;

class Restore extends Component
{
    public User $user;

    public function restoreEmployee()
    {
        $this->user->restore();

        $this->emit('refresh-deleted');

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
