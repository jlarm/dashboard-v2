<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;

class StoreController extends Controller
{
    public function show(Store $store)
    {
        return view('dealer.store.show', compact('store'));
    }
}
