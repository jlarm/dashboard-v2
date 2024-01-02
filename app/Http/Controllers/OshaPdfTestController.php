<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\OshaAudit;
use Illuminate\View\View;

class OshaPdfTestController extends Controller
{
    public function __invoke(): View
    {
        $audit = OshaAudit::with('user')->first();

        return view('dealer.osha-audit-pdf', compact('audit'));
    }
}
