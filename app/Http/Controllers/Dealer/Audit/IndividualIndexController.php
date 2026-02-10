<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use Illuminate\View\View;

class IndividualIndexController extends Controller
{
    public function __invoke(): View
    {
        $store = Store::query()->first();

        return view('dealer.audit.individual.index', ['store' => $store]);
    }
}
