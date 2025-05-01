<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Jobs\Audit\GenerateOshaPdfJob;
use App\Jobs\Audit\UploadOshaPdfJob;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Services\ReminderService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Bus;
use Illuminate\View\View;
use Livewire\Component;

class GenerateButton extends Component
{
    public OshaViolationAudit $oshaViolationAudit;

    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateOshaPdfJob($this->oshaViolationAudit),
            new UploadOshaPdfJob($this->oshaViolationAudit),
        ])->dispatch();

        $this->createRemediationReminders();

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

    private function createRemediationReminders(): void
    {
        ReminderService::createRemediationReminders($this->oshaViolationAudit);
    }
}
