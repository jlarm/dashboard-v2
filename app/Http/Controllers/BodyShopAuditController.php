<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\BodyShopAudit;
use Illuminate\View\View;

class BodyShopAuditController extends Controller
{
    public function __invoke(BodyShopAudit $bodyShopAudit): View
    {
        return view('dealer.audit.body-shop.show', [
            'bodyShopAudit' => $bodyShopAudit,
        ]);
    }
}
