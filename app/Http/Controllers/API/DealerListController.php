<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dealership;
use Illuminate\Http\JsonResponse;

class DealerListController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $dealers = Dealership::orderBy('name')->get();

        return response()->json([
            'dealers' => $dealers,
        ]);
    }
}
