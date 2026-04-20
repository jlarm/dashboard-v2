<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\Dealership\Actions\CreateDealership;
use App\Domain\Central\Dealership\Data\DealershipData;
use App\Domain\Central\Dealership\Queries\SearchDealerships;
use App\Domain\Central\User\Queries\GetConsultants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Central\Dealership\CreateRequest;
use App\Http\Resources\Central\DealershipResource;
use App\Models\Dealership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class DealershipController extends Controller
{
    public function index(
        Request $request,
        SearchDealerships $searchDealerships,
        GetConsultants $getConsultants,
    ): Response {
        $this->authorize('viewAny', Dealership::class);

        $user = $request->user();
        $search = $request->string('search')->toString() ?: null;

        return Inertia::render('central/dealership/Index', [
            'filters' => $request->only(['search']),
            'dealerships' => Inertia::defer(
                fn () => DealershipResource::collection($searchDealerships->handle($search, $user)),
            ),
            'consultants' => Inertia::defer(fn (): Collection => $getConsultants->handle($user->id)),
        ]);
    }

    public function store(
        CreateRequest $request,
        CreateDealership $createDealership,
    ): RedirectResponse {
        $createDealership->handle($request->user(), new DealershipData(
            $request->validated('name'),
            $request->validated('consultant_ids', []),
        ));

        Inertia::flash('success', 'Dealership created successfully.');

        return back();
    }
}
