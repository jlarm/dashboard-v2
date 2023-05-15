<?php

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;

class OshaCreateController extends Controller
{
    public function __invoke()
    {
        $audit = OshaAudit::create([
            'user_id' => auth()->id(),
            'store_id' => request()->store_id ?? Store::first()->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->to(route('dealer.audit.osha.show', $audit->id));
    }
}
