<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Enums\AuditTypes;
use App\Jobs\Audit\GenerateBodyShopPdfJob;
use App\Jobs\Audit\UploadBodyShopPdfJob;
use App\Jobs\RemediationReminderEmailJob;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class GenerateButton extends Component
{
    public BodyShopViolationAudit $bodyShopViolationAudit;

    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateBodyShopPdfJob($this->bodyShopViolationAudit),
            new UploadBodyShopPdfJob($this->bodyShopViolationAudit),
            new RemediationReminderEmailJob(
                tenants: (bool) app('multipleStoresExist'),
                store: $this->bodyShopViolationAudit->store,
                audit: $this->bodyShopViolationAudit,
                auditType: AuditTypes::BODYSHOP
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

        $this->dispatch('pdfGenerated');
    }

    public function render()
    {
        return view('livewire.dealer.audit.body-shop.generate-button');
    }
}
