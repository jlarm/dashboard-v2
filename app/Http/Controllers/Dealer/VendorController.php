<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    public function index()
    {
        return view('dealer.vendor.form');
    }
}
