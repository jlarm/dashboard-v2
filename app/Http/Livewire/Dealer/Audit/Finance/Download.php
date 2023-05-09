<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Livewire\Component;

class Download extends Component
{
    public FinanceAudit $financeAudit;
    public function download()
    {
        return \Storage::disk('do-audits')->download(tenant('id') . '/audits/finance/' . $this->financeAudit->pdf_path);
    }
    public function render()
    {
        return view('livewire.dealer.audit.finance.download');
    }
}
