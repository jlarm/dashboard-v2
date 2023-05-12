<?php

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Store;

class BodyShopCreateController extends Controller
{
    public function __invoke()
    {
        $audit = BodyShopAudit::create([
            'user_id' => auth()->id(),
            'store_id' => request()->store_id ?? Store::first()->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->to(route('dealer.audit.body-shop.show', $audit->id));
    }
}
