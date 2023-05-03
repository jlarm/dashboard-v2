<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class Download extends Component
{
    public FinanceAudit $financeAudit;
    public function pdfTest(): void
    {
        $html = view('dealer.audit.finance.download', [
            'financeAudit' => $this->financeAudit
        ])->render();

        $path = storage_path('app/finance-audits');

        if(!\File::isDirectory($path)) {
            \File::makeDirectory(storage_path('app/finance-audits'), $mode = 0777, true, true);
        }

        if(\Storage::disk('public')->exists('finance-audits/finance-audit.pdf')) {
            \Storage::disk('public')->delete('finance-audits/finance-audit.pdf');
        }

        Browsershot::html($html)
            ->showBackground()
            ->margins(10, 10, 10, 10)
            ->save(storage_path('app/finance-audits/finance-audit.pdf'));
    }
    public function render()
    {
        return view('livewire.dealer.audit.finance.download');
    }
}
