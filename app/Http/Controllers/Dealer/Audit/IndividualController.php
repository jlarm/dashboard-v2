<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;

class IndividualController extends Controller
{
    public Store $store;

    public function __invoke(IndividualAudit $individualAudit): View
    {
        $children = IndividualAudit::query()
            ->where('parent_id', $individualAudit->id)
            ->where('draft', 1)
            ->count();
        $parent = IndividualAudit::query()->where('id', $individualAudit->id)->where('draft', 1)->count();

        return view('dealer.audit.individual.show', [
            'individualAudit' => $individualAudit->load('children'),
            'drafts' => $children + $parent,
            'audits' => IndividualAudit::query()->where('parent_id', $individualAudit->id)
                ->with('store')
                ->get(),
        ]);
    }
}
