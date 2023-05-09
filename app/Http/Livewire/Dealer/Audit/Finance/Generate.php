<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Jobs\GenerateAuditPdfJob;
use App\Jobs\UploadAuditToDigitalOceanJob;
use App\Models\Dealer\Audit\FinanceAudit;
use Bus;
use Livewire\Component;

class Generate extends Component
{
    public FinanceAudit $financeAudit;
    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateAuditPdfJob($this->financeAudit),
            new UploadAuditToDigitalOceanJob($this->financeAudit)
        ])->dispatch();
    }
    public function render()
    {
        return view('livewire.dealer.audit.finance.generate');
    }
}
