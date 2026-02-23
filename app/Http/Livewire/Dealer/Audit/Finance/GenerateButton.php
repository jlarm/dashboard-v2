<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Enums\AuditTypes;
use App\Jobs\Audit\GenerateGlbaPdfJob;
use App\Jobs\Audit\UploadGlbaPdfJob;
use App\Jobs\RemediationReminderEmailJob;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class GenerateButton extends Component
{
    public GlbaViolationAudit $glbaViolationAudit;

    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateGlbaPdfJob($this->glbaViolationAudit),
            new UploadGlbaPdfJob($this->glbaViolationAudit),
            new RemediationReminderEmailJob(
                tenants: (bool) tenant('locations'),
                store: $this->glbaViolationAudit->store,
                audit: $this->glbaViolationAudit,
                auditType: AuditTypes::GLBA
            ),
        ])
            ->catch(function (Throwable $e): void {
                Notification::make()
                    ->title('Error in PDF generation process')
                    ->body($e->getMessage())
                    ->icon('heroicon-o-exclamation-circle')
                    ->iconColor('danger')
                    ->send();
                Log::error($e->getMessage());
            })
            ->dispatch();

        Notification::make()
            ->title('Violation PDF Created Successfully')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();

        $this->emit('pdfGenerated');
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.generate-button');
    }
}
