<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public Store $store;
    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.finance.index', [
            'financeAudits' => FinanceAudit::where('store_id', $this->store->id)->orderBy('created_at', 'desc')->get()
        ])->layout('components.dealer-app');
    }
}
