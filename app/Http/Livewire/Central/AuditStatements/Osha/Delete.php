<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Osha;

use App\Models\OshaViolationStatements;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Delete extends Modal
{
    use InteractsWithConfirmationModal;

    public OshaViolationStatements $oshaViolationStatements;

    public function delete(): void
    {
        $this->askForConfirmation(
            callback: function (): void {
                $this->oshaViolationStatements->delete();

                Notification::make()
                    ->title('Statement Deleted Successfully!')
                    ->success()
                    ->send();

                to_route('osha-violations.index');
            }
        );
    }

    public function render(): View
    {
        return view('livewire.central.audit-statements.osha.delete');
    }
}
