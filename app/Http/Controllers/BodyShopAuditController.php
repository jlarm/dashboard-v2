<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\BodyShopAudit;

class BodyShopAuditController extends Controller
{
    public function __invoke(BodyShopAudit $bodyShopAudit)
    {
        return view('dealer.audit.body-shop.show', [
            'bodyShopAudit' => $bodyShopAudit,
        ]);
    }
}
