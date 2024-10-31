<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Http\Livewire\Dealer\Audit\Osha\Modal;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class DeletedIndexItem extends Modal
{
    use InteractsWithConfirmationModal;

    public User $user;

    public function restoreEmployee(): void
    {
        $this->askForConfirmation(
            callback: function () {
                $this->user->restore();

                $this->emit('refresh-deleted');

                Notification::make()
                    ->title('Employee Restored Successfully!')
                    ->success()
                    ->send();
            },
            prompt: [
                'title' => __('Restore'),
                'message' => __('Are you sure you want to restore '.$this->user->name.'\'s account?'),
                'confirm' => __('Yes, Restore')
            ]
        );
    }

    public function render(): View
    {
        return view('livewire.dealer.employee.deleted-index-item');
    }
}
