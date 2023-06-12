<?php

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\IndividualAudit;

class SingleIndividualController extends Controller
{
    public function __invoke(IndividualAudit $individualAudit)
    {
        return view('dealer.audit.individual.edit', [
            'individualAudit' => $individualAudit,
        ]);
    }
}
