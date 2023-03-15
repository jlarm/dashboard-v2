<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;

class StoreController extends Controller
{
    public function edit(Store $store)
    {
        $userCount = Store::where('id', $store->id)->first()->users()->count();

        return view('dealer.store.edit', compact(['store', 'userCount']));
    }

    public function onboarding(Store $store)
    {
        return view('dealer.general.onboard-form', compact('store'));
    }
}
