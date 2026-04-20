<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\Dealership\Queries\SearchDealerships;
use App\Http\Controllers\Controller;
use App\Http\Resources\Central\DealershipResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request, SearchDealerships $searchDealerships): Response
    {
        $user = $request->user();

        return Inertia::render('central/Dashboard', [
            'dealerships' => Inertia::defer(fn () => DealershipResource::collection(
                $searchDealerships->handle(null, $user),
            )),
        ]);
    }
}
