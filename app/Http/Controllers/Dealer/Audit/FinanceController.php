<?php

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\FinanceAudit;

class FinanceController extends Controller
{
    public function __invoke(FinanceAudit $financeAudit)
    {
        return view('dealer.audit.finance.show', [
            'financeAudit' => $financeAudit,
        ]);
    }
}
