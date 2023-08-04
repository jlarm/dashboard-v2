<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\BodyShopAudit;

class BodyShopPdfTestController extends Controller
{
    public function __invoke()
    {
        $audit = BodyShopAudit::with('user')->first();
        return view('dealer.body-shop-audit-pdf', compact('audit'));
    }
}
