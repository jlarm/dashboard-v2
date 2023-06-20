<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;

class ManualController extends Controller
{
    public function __invoke()
    {
        $store = Store::first();
        return view('dealer.manual.index', compact('store'));
    }
}
