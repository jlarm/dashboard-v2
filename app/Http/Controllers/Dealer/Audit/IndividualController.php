<?php

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;

class IndividualController extends Controller
{
    public Store $store;
    public function __invoke(IndividualAudit $individualAudit)
    {
        $children = IndividualAudit::query()
            ->where('parent_id', $individualAudit->id)
            ->where('draft', 1)
            ->count();
        $parent = IndividualAudit::where('id', $individualAudit->id)->where('draft', 1)->count();
        return view('dealer.audit.individual.show', [
            'individualAudit' => $individualAudit->load('children'),
            'drafts' => $children + $parent,
            'audits' => IndividualAudit::where('parent_id', $individualAudit->id)
                ->with('store')
                ->get(),
        ]);
    }
}
