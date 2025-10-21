<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;

class DealJacketController extends Controller
{
    public function show(Store $store, DealJacketGroup $dealJacketGroup, DealJacket $dealJacket)
    {
        return view('tenant.audit.deal-jacket.deal-jacket-show', [
            'store' => $store,
            'dealJacketGroup' => $dealJacketGroup,
            'dealJacket' => $dealJacket,
        ]);
    }

    public function create(Store $store, DealJacketGroup $dealJacketGroup)
    {
        return view('tenant.audit.deal-jacket.form', [
            'store' => $store,
            'dealJacketGroup' => $dealJacketGroup,
            'dealJacket' => null,
        ]);
    }

    public function edit(Store $store, DealJacketGroup $dealJacketGroup, DealJacket $dealJacket)
    {
        return view('tenant.audit.deal-jacket.form', [
            'store' => $store,
            'dealJacketGroup' => $dealJacketGroup,
            'dealJacket' => $dealJacket,
        ]);
    }
}
