<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Http\Livewire\Dealer\Audit\Osha\Modal;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\View\View;

class DeletedIndexItem extends Modal
{
    public User $user;

    public function render(): View
    {
        return view('livewire.dealer.employee.deleted-index-item');
    }
}
