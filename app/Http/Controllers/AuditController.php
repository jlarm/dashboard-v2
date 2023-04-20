<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Audit;

class AuditController extends Controller
{
    public function __invoke(Audit $audit)
    {
        return view('dealer.audit.show', [
            'audit' => $audit,
        ]);
    }
}
