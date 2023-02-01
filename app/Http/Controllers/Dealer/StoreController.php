<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use App\Models\User;

class StoreController extends Controller
{

    public function show(Store $store)
    {
        $userCount = User::where('store_id', $store->id)->count();
        return view('dealer.store.show', compact(['store', 'userCount']));
    }
}
