<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\OshaViolationAudit;
use Illuminate\View\View;

class OshaPdfTestController extends Controller
{
    public function __invoke(): View
    {
        $audit = OshaViolationAudit::with('user', 'violations')->first();

        return view('dealer.osha-audit-pdf', compact('audit'));
    }
}
