<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;

class StoreController extends Controller
{
    public function show(Store $store)
    {
        $userCount = Store::where('id', $store->id)->first()->users()->count();

        return view('dealer.store.show', compact(['store', 'userCount']));
    }
}
