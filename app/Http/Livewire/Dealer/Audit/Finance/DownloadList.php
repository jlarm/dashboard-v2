<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Livewire\Component;

class DownloadList extends Component
{
    public function render()
    {
        return view('livewire.dealer.audit.finance.download-list', [
            'audits' => FinanceAudit::where('pdf_path', '!=', null)->latest()->get(),
        ])->layout('components.dealer-app');
    }
}
