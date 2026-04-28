<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Store;

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
    public function index(Request $request): InertiaResponse
    {
        $this->authorize('viewAny', Store::class);

        $stores = Store::query()
            ->orderBy('name')
            ->get(['id', 'name', 'address', 'city', 'state', 'postal_code', 'phone', 'website']);

        $user = $request->user();

        return Inertia::render('tenant/location/Index', [
            'locations' => LocationResource::collection($stores),
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

    public function update(UpdateStoreRequest $request, Store $store): RedirectResponse
    {
        $store->update($request->validated());

        return back()->with('flash.success', 'Location updated successfully.');
    }
}
