<?php

namespace App\Http\Controllers\Dealer\Store;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;

class SettingsController extends Controller
{
    public function __invoke()
    {
        $store = Store::first();
        return view('dealer.store.settings', compact('store'));
    }
}
