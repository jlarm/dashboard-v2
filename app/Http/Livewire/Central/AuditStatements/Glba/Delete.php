<?php

namespace App\Http\Livewire\Central\AuditStatements\Glba;

use App\Models\GlbaViolationStatements;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Delete extends Modal
{
    use InteractsWithConfirmationModal;

    public GlbaViolationStatements $glbaViolationStatements;

    public function delete(): void
    {
        $this->askForConfirmation(
            callback: function () {
                $this->glbaViolationStatements->delete();

                Notification::make()
                    ->title('Statement Deleted Successfully!')
                    ->success()
                    ->send();

                redirect()->route('glba-violations.index');
            }
        );
    }

    public function render(): View
    {
        return view('livewire.central.audit-statements.glba.delete');
    }
}
