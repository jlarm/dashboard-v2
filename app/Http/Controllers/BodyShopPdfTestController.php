<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\BodyShopAudit;
use Illuminate\View\View;

class BodyShopPdfTestController extends Controller
{
    public function __invoke(): View
    {
        $audit = BodyShopAudit::with('user')->first();

        return view('dealer.body-shop-audit-pdf', ['audit' => $audit]);
    }
}
