<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use Illuminate\View\View;

class ManualController extends Controller
{
    public function __invoke(): View
    {
        $store = Store::first();

        return view('dealer.manual.index', compact('store'));
    }
}
