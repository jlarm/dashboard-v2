<?php

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;

class SingleIndividualController extends Controller
{
    public IndividualAudit $individualAudit;

    public Store $store;

    public function __invoke(IndividualAudit $individualAudit): View
    {
        return view('dealer.audit.individual.edit', [
            'individualAudit' => $individualAudit,
        ]);
    }
}
