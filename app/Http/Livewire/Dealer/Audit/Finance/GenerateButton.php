<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Jobs\Audit\GenerateGlbaPdfJob;
use App\Jobs\Audit\UploadGlbaPdfJob;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Bus;
use Livewire\Component;

class GenerateButton extends Component
{
    public GlbaViolationAudit $glbaViolationAudit;

    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateGlbaPdfJob($this->glbaViolationAudit),
            new UploadGlbaPdfJob($this->glbaViolationAudit),
        ])->dispatch();

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
