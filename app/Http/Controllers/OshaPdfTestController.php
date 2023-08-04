<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\OshaAudit;

class OshaPdfTestController extends Controller
{
    public function __invoke()
    {
        $audit = OshaAudit::with('user')->first();
        return view('dealer.osha-audit-pdf', compact('audit'));
    }
}
