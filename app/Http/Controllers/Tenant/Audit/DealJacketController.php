<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;

class DealJacketController extends Controller
{
    public function show(DealJacketGroup $dealJacketGroup, DealJacket $dealJacket)
    {
        return view('tenant.audit.deal-jacket.deal-jacket-show', [
            'dealJacketGroup' => $dealJacketGroup,
            'dealJacket' => $dealJacket,
        ]);
    }

    public function create(DealJacketGroup $dealJacketGroup)
    {
        return view('tenant.audit.deal-jacket.form', [
            'dealJacketGroup' => $dealJacketGroup,
            'dealJacket' => null,
        ]);
    }

    public function edit(DealJacketGroup $dealJacketGroup, DealJacket $dealJacket)
    {
        return view('tenant.audit.deal-jacket.form', [
            'dealJacketGroup' => $dealJacketGroup,
            'dealJacket' => $dealJacket,
        ]);
    }
}
