<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function index(): View
    {
        Store::query()->first();

        return view('dealer.vendor.index', [
            'stores' => Store::query()->count(),
        ]);
    }

    public function show(): View
    {
        $id = app('request')->input('id');
        $vendor = Vendor::query()->where('id', $id)->firstOrFail();

        return view('dealer.vendor.form', [
            'vendor' => $vendor,
        ]);
    }
}
