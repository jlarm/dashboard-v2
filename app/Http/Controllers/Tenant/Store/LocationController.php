<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Store;

use App\Domain\Tenant\Store\Actions\UpdateStore;
use App\Domain\Tenant\Store\Data\LocationData;
use App\Domain\Tenant\Store\Queries\GetLocations;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Store\CreateStoreRequest;
use App\Http\Requests\Tenant\Store\UpdateStoreRequest;
use App\Http\Resources\Tenant\LocationResource;
use App\Models\Dealer\Store;
use App\Services\StoreCreator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class LocationController extends Controller
{
    public function index(Request $request, GetLocations $getLocations): InertiaResponse
    {
        $this->authorize('viewAny', Store::class);

        $user = $request->user();

        return Inertia::render('tenant/location/Index', [
            'locations' => LocationResource::collection(
                array_map(
                    static fn (LocationData $location): array => $location->toArray(),
                    $getLocations->handle(),
                ),
            ),
            'can' => [
                'create' => $user?->can('create', Store::class) ?? false,
                'update' => $user?->can('update', Store::class) ?? false,
            ],
        ]);
    }

    public function store(CreateStoreRequest $request, StoreCreator $storeCreator): RedirectResponse
    {
        $storeCreator->create($request->toData()->toStoreCreatorPayload());

        return back()->with('flash.success', 'Location created successfully.');
    }

    public function update(UpdateStoreRequest $request, Store $store, UpdateStore $updateStore): RedirectResponse
    {
        $updateStore->handle($store, $request->toData());

        return back()->with('flash.success', 'Location updated successfully.');
    }
}
