<?php

namespace App\Http\Controllers\Dealer\Store;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use Illuminate\View\View;

class StoreVendorController extends Controller
{
    public function index(Store $store): View
    {
        return view('dealer.store.multi.vendor-index', compact('store'));
    }
}
