<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Create extends Component
{
    public Store $store;
    public function mount()
    {
        $financeAudit = FinanceAudit::create([
            'store_id' => $this->store->id,
            'user_id' => auth()->user()->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->to(route('dealer.stores.audits.finance.show', [$this->store, $financeAudit]));
    }
}
