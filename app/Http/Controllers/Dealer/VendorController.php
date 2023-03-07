<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Vendor;

class VendorController extends Controller
{
    public function show()
    {
        $id = app('request')->input('id');
        $vendor = Vendor::where('id', $id)->firstOrFail();

        return view('dealer.vendor.form', [
            'vendor' => $vendor,
        ]);
    }
}
