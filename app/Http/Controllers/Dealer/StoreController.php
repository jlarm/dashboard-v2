<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function show(Store $store): View
    {
        $userCount = Store::query()->where('id', $store->id)->first()->users()->count();

        return view('dealer.store.show', ['store' => $store, 'userCount' => $userCount]);
    }

    public function edit(Store $store): View
    {
        $userCount = Store::query()->where('id', $store->id)->first()->users()->count();

        return view('dealer.store.edit', ['store' => $store, 'userCount' => $userCount]);
    }

    public function onboarding(Store $store): View
    {
        return view('dealer.general.onboard-form', ['store' => $store]);
    }
}
