<?php

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class IndividualCreateController extends Controller
{
    public function __invoke(IndividualAudit $individualAudit): RedirectResponse
    {
        $audit = IndividualAudit::create([
            'parent_id' => $individualAudit->id ?? null,
            'deal_jacket_date' => now()->format('Y-m-d'),
            'uuid' => (string) Str::uuid(),
            'user_id' => auth()->id(),
            'store_id' => request()->store_id ?? Store::first()->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->to(route('dealer.audit.individual.edit', $audit->uuid));
    }
}
