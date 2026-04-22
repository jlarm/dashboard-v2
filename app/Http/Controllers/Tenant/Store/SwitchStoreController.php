<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Store;

use App\Domain\Tenant\Store\Actions\SwitchCurrentStore;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Store\SwitchStoreRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class SwitchStoreController extends Controller
{
    public function __invoke(SwitchStoreRequest $request, SwitchCurrentStore $action): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $action->handle($user, $request->storeId());

        return back();
    }
}
