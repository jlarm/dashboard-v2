<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\Dealership;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dealership\CreateRequest;
use App\Models\User;
use App\Services\DealershipCreator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CreateController extends Controller
{
    public function __invoke(CreateRequest $request, DealershipCreator $dealershipCreator): RedirectResponse
    {
        $centralUser = $request->user();

        abort_unless($centralUser instanceof User, 403);

        $validated = $request->validated();
        $dealershipCreator->create($centralUser, (string) $validated['name']);

        session()->flash('flash.type', 'success');
        session()->flash('flash.title', 'Dealership Created');
        session()->flash('flash.message', $validated['name'].' has successfully been created.');

        return to_route('dealerships.index');
    }
}
