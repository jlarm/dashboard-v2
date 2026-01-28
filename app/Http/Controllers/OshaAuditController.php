<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\OshaAudit;
use Illuminate\View\View;

class OshaAuditController extends Controller
{
    public function __invoke(OshaAudit $oshaAudit): View
    {
        return view('dealer.audit.osha.show', [
            'oshaAudit' => $oshaAudit,
        ]);
    }
}
