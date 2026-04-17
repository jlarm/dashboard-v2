<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Delete extends Modal
{
    use InteractsWithConfirmationModal;

    public Contract $contract;

    public function delete(): void
    {
        $this->askForConfirmation(
            callback: function (): void {
                $this->contract->delete();
                $this->dispatch('contractDeleted');

                Notification::make()
                    ->title('Contract Deleted')
                    ->success()
                    ->send();
            },
            prompt: [
                'title' => 'Delete Contract ',
                'message' => 'Are you sure you want to delete this contract?',
                'confirm' => 'Yes, delete',
                'cancel' => 'No, cancel',
            ],
        );
    }

    public function render()
    {
        return view('livewire.central.contracts.delete');
    }
}
