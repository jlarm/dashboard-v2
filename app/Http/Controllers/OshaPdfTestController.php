<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\OshaViolationAudit;
use Illuminate\View\View;

class OshaPdfTestController extends Controller
{
    public function __invoke(): View
    {
        $audit = OshaViolationAudit::with('user', 'violations', 'auditComments')->first();

        return view('dealer.osha-audit-pdf', compact('audit'));
    }
}
