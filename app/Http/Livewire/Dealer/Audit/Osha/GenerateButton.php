<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Enums\AuditTypes;
use App\Jobs\Audit\GenerateOshaPdfJob;
use App\Jobs\Audit\UploadOshaPdfJob;
use App\Jobs\RemediationReminderEmailJob;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;
use Throwable;

class GenerateButton extends Component
{
    public Store $store;
    public OshaViolationAudit $oshaViolationAudit;

    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateOshaPdfJob($this->oshaViolationAudit),
            new UploadOshaPdfJob($this->oshaViolationAudit),
            new RemediationReminderEmailJob(
                tenants: tenant('locations') ? $this->store->slug : '',
                store: $this->store,
                audit: $this->oshaViolationAudit,
                auditType: AuditTypes::OSHA
            ),
        ])->catch(function (Throwable $e) {
            Notification::make()
                ->title('Error in PDF generation process')
                ->body($e->getMessage())
                ->icon('heroicon-o-exclamation-circle')
                ->iconColor('danger')
                ->send();
            Log::error($e->getMessage());
        })->dispatch();

        Notification::make()
            ->title('Violation PDF Created Successfully')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();

        $this->emit('pdfGenerated');
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.osha.generate-button');
    }
}
