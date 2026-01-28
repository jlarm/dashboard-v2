<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Sds;

use App\Models\Sds;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Storage;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Delete extends Modal
{
    use InteractsWithConfirmationModal;

    public Sds $sds;

    public function delete(): void
    {
        $this->askForConfirmation(
            callback: function () {
                Storage::disk('sds-sheets')->delete($this->sds->file_name);

                $this->sds->delete();

                $this->emit('refresh');

                Notification::make()
                    ->title('SDS Sheet Added Successfully!')
                    ->success()
                    ->send();
            },
            prompt: [
                'title' => 'Delete SDS Sheet',
                'message' => 'Are you sure you want to delete this sheet?',
                'confirm' => 'Yes',
                'cancel' => 'Cancel',
            ]
        );
    }

    public function render(): View
    {
        return view('livewire.central.sds.delete');
    }
}
