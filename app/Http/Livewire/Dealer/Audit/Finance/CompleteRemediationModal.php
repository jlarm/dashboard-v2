<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Jobs\Audit\GenerateGlbaRemediationPdfJob;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class CompleteRemediationModal extends Modal
{
    use InteractsWithConfirmationModal;

    public $glbaViolationAudit;

    public function mount(GlbaViolationAudit $glbaViolationAudit): void
    {
        $this->glbaViolationAudit = $glbaViolationAudit;
    }

    public function generate(): void
    {
        dispatch(new GenerateGlbaRemediationPdfJob($this->glbaViolationAudit));

        $this->close();

        Notification::make()
            ->title('PDF Successfully Generated!')
            ->success()
            ->send();
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.audit.finance.complete-remediation-modal');
    }
}
