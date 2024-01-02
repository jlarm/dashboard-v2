<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\FinanceAudit;
use Illuminate\View\View;

class GlbaPdfTestController extends Controller
{
    public function __invoke(): View
    {
        $audit = FinanceAudit::with('user')->first();

        return view('dealer.glba-audit-pdf', compact('audit'));
    }
}
