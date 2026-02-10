<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer\Manual;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use Illuminate\View\View;

class OshaController extends Controller
{
    public function __invoke(): View
    {
        $store = Store::query()->first();

        return view('dealer.manual.osha', ['store' => $store]);
    }
}
