<?php

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\IndividualAudit;

class IndividualController extends Controller
{
    public function __invoke(IndividualAudit $individualAudit)
    {
        return view('dealer.audit.individual.show', [
            'individualAudit' => $individualAudit,
        ]);
    }
}
