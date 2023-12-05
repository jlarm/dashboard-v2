<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dealership;

class DealerListController extends Controller
{
    public function __invoke()
    {
        $dealers = Dealership::orderBy('name')->get();

        return response()->json([
            'dealers' => $dealers
        ]);
    }
}
