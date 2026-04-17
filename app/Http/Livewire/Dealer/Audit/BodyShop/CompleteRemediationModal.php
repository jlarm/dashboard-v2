<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Jobs\Audit\GenerateBodyShopRemediationPdfJob;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class CompleteRemediationModal extends Modal
{
    use InteractsWithConfirmationModal;

    public $bodyShopViolationAudit;

    public function mount(BodyShopViolationAudit $bodyShopViolationAudit): void
    {
        $this->bodyShopViolationAudit = $bodyShopViolationAudit;
    }

    public function generate(): void
    {
        dispatch(new GenerateBodyShopRemediationPdfJob($this->bodyShopViolationAudit));

        $this->close();

        Notification::make()
            ->title('PDF Successfully Generated!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.body-shop.complete-remediation-modal');
    }
}
