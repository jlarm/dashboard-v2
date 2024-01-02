<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function show(Store $store): View
    {
        $userCount = Store::where('id', $store->id)->first()->users()->count();

        return view('dealer.store.show', compact(['store', 'userCount']));
    }

    public function edit(Store $store): View
    {
        $userCount = Store::where('id', $store->id)->first()->users()->count();

        return view('dealer.store.edit', compact(['store', 'userCount']));
    }

    public function onboarding(Store $store): View
    {
        return view('dealer.general.onboard-form', compact('store'));
    }
}
