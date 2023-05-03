<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;

class FinanceCreateController extends Controller
{
    public function __invoke()
    {
        $audit = FinanceAudit::create([
            'user_id' => auth()->id(),
            'store_id' => $this->store->id ?? Store::first()->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->route('dealer.audit.finance.show', $audit->id);
    }
}
