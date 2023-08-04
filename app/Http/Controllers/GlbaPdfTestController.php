<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\FinanceAudit;

class GlbaPdfTestController extends Controller
{
    public function __invoke()
    {
        $audit = FinanceAudit::with('user')->first();
        return view('dealer.glba-audit-pdf', compact('audit'));
    }
}
