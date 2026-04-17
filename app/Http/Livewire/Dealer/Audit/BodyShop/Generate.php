<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Jobs\GenerateBodyShopAuditPdfJob;
use App\Jobs\UploadBodyShopAuditToDigitalOceanJob;
use App\Models\Dealer\Audit\BodyShopAudit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Bus;
use Livewire\Component;

class Generate extends Component
{
    public BodyShopAudit $bodyShopAudit;

    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateBodyShopAuditPdfJob($this->bodyShopAudit),
            new UploadBodyShopAuditToDigitalOceanJob($this->bodyShopAudit),
        ])->dispatch();
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.audit.body-shop.generate');
    }
}
