<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Livewire\Component;

class IndexItem extends Component
{
    public FinanceAudit $audit;
    public function render()
    {
        return view('livewire.dealer.audit.finance.index-item');
    }
}
