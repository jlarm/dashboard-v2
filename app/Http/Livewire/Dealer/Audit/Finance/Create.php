<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use Auth;
use Livewire\Component;

class Create extends Component
{
    public function mount()
    {
        $audit = FinanceAudit::create([
            'user_id' => Auth::user()->id,
            'store_id' => $this->store->id ?? Store::first()->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

//        return redirect(route('dealer.audit.finance.show', $audit));
        $this->redirectTo = route('dealer.audit.finance.show', $audit);
    }

}
