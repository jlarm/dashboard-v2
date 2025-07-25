<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Jobs\Audit\GenerateGlbaRemediationPdfJob;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class CompleteRemediationModal extends Modal
{
    use InteractsWithConfirmationModal;

    public $glbaViolationAudit;

    public function mount(glbaViolationAudit $glbaViolationAudit): void
    {
        $this->glbaViolationAudit = $glbaViolationAudit;
    }

    public function generate(): void
    {
        GenerateGlbaRemediationPdfJob::dispatch($this->glbaViolationAudit);

        $this->close();

        Notification::make()
            ->title('PDF Successfully Generated!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.complete-remediation-modal');
    }
}
