<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\OshaAudit;

class OshaAuditController extends Controller
{
    public function __invoke(OshaAudit $oshaAudit)
    {
        return view('dealer.audit.osha.show', [
            'oshaAudit' => $oshaAudit,
        ]);
    }
}
