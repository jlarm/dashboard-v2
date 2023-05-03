<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Jobs\GenerateAuditPdfJob;
use App\Models\Dealer\Audit\FinanceAudit;
use Livewire\Component;

class Generate extends Component
{
    public FinanceAudit $financeAudit;
    public function generatePdf(): void
    {
        GenerateAuditPdfJob::dispatch($this->financeAudit);
    }
    public function render()
    {
        return view('livewire.dealer.audit.finance.generate');
    }
}
