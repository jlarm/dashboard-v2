<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Livewire\Component;

class OldAuditIndex extends Component
{
    public FinanceAudit $financeAudit;

    public function quarter(): string
    {
        return $this->financeAudit->audit_date->format('Y').' Q'.ceil($this->financeAudit->audit_date->format('n') / 3);
    }

    public function grade(): string
    {
        return match (true) {
            $this->financeAudit->rating >= 90 => 'A',
            $this->financeAudit->rating >= 80 => 'B',
            $this->financeAudit->rating >= 70 => 'C',
            $this->financeAudit->rating >= 60 => 'D',
            $this->financeAudit->rating >= 50 => 'F',
            default => 'N/A',
        };
    }

    public function download()
    {
        return \Storage::disk('do-audits')->download(tenant('id').'/osha/'.$this->financeAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.old-audit-index');
    }
}
