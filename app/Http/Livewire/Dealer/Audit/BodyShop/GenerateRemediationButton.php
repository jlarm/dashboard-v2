<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Jobs\Audit\GenerateBodyShopRemediationPdfJob;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class GenerateRemediationButton extends Component
{
    public BodyShopViolationAudit $bodyShopViolationAudit;

    public function generatePdf()
    {
        return Storage::disk('armpaudits')->download($this->bodyShopViolationAudit->remediation_pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.body-shop.generate-remediation-button');
    }
}
