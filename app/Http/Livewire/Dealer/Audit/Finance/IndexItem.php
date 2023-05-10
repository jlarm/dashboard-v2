<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class IndexItem extends Component
{
    public FinanceAudit $financeAudit;
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.audit.finance.index-item');
    }
}
