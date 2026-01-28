<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Delete extends Modal
{
    use InteractsWithConfirmationModal;

    public Dealership $dealership;

    public function delete(): void
    {
        $this->askForConfirmation(
            callback: function () {
                try {
                    DB::beginTransaction();

                    $this->dealership->users()->detach();

                    $this->dealership->delete();

                    DB::commit();

                    $this->emit('refreshDealerships');

                    Notification::make()
                        ->title('Dealership Deleted')
                        ->success()
                        ->send();
                } catch (Exception $e) {
                    DB::rollBack();

                    Notification::make()
                        ->title('Error Deleting Dealership')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            },
            prompt: [
                'title' => 'Delete Dealership ',
                'message' => 'Are you sure you want to delete this dealership?',
                'confirm' => 'Yes, delete',
                'cancel' => 'No, cancel',
            ]
        );
    }

    public function render(): View
    {
        return view('livewire.central.dealership.delete');
    }
}
