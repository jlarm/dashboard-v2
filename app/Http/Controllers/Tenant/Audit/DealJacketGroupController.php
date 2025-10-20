<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\DealJacketGroup;

class DealJacketGroupController extends Controller
{
    public function show(DealJacketGroup $dealJacketGroup)
    {
        return view('tenant.audit.deal-jacket.show', [
            'dealJacketGroup' => $dealJacketGroup,
        ]);
    }
}
