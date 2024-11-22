<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Jobs\Audit\GenerateBodyShopPdfJob;
use App\Jobs\Audit\UploadBodyShopPdfJob;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Bus;
use Livewire\Component;

class GenerateButton extends Component
{
    public BodyShopViolationAudit $bodyShopViolationAudit;

    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateBodyShopPdfJob($this->bodyShopViolationAudit),
            new UploadBodyShopPdfJob($this->bodyShopViolationAudit),
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
        return view('livewire.dealer.audit.body-shop.generate-button');
    }
}
