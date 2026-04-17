<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DealJacketGroupController extends Controller
{
    public function show(Store $store, DealJacketGroup $dealJacketGroup): Factory|View
    {
        return view('tenant.audit.deal-jacket.show', [
            'store' => $store,
            'dealJacketGroup' => $dealJacketGroup,
        ]);
    }
}
