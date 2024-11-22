<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Jobs\Audit\GenerateOshaRemediationPdfJob;
use App\Models\Dealer\Audit\OshaViolationAudit;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class CompleteRemediationModal extends Modal
{
    use InteractsWithConfirmationModal;

    public $oshaViolationAudit;

    public function mount(OshaViolationAudit $oshaViolationAudit): void
    {
        $this->oshaViolationAudit = $oshaViolationAudit;
    }

    public function generate(): void
    {
        GenerateOshaRemediationPdfJob::dispatch($this->oshaViolationAudit);

        $this->close();

        Notification::make()
            ->title('PDF Successfully Generated!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.osha.complete-remediation-modal');
    }
}
