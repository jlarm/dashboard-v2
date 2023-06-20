<?php

namespace App\Http\Controllers\Dealer\Manual;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;

class IspController extends Controller
{
    public function __invoke()
    {
        $store = Store::first();
        return view('dealer.manual.isp', compact('store'));
    }
}
