<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Store\CreateStoreRequest;
use App\Services\StoreCreator;
use Illuminate\Http\RedirectResponse;

class CreateStoreController extends Controller
{
    public function __invoke(CreateStoreRequest $request, StoreCreator $storeCreator): RedirectResponse
    {
        $storeCreator->create($request->toData()->toStoreCreatorPayload());

        return back();
    }
}
