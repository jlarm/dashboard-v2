<?php

namespace App\Http\Controllers;


use App\Models\Dealer\Audit\OshaAudit;

class AuditController extends Controller
{
    public function __invoke(OshaAudit $audit)
    {
        return view('dealer.audit.show', [
            'audit' => $audit,
        ]);
    }
}
