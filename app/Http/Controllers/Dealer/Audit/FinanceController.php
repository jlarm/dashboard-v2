<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\FinanceAudit;
use Illuminate\View\View;

class FinanceController extends Controller
{
    public function __invoke(FinanceAudit $financeAudit): View
    {
        return view('dealer.audit.finance.show', [
            'financeAudit' => $financeAudit,
        ]);
    }
}
