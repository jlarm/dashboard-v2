<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dealer\Store\CreateFirstStoreRequest;
use App\Models\Dealer\Store;
use App\Services\StoreCreator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CreateFirstStoreController extends Controller
{
    public function __invoke(CreateFirstStoreRequest $request, StoreCreator $storeCreator): RedirectResponse
    {
        if (Store::query()->exists()) {
            return redirect()->route('dealer.dashboard');
        }

        $storeCreator->create($request->validated());

        session()->flash('flash.type', 'success');
        session()->flash('flash.title', 'Store Created');
        session()->flash('flash.message', 'Your first store has been created successfully.');

        return redirect()->route('dealer.dashboard');
    }
}
