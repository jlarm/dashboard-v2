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
        $storeId = $request->storeId();

        $action->handle($user, $storeId);

        // The scans pages require a single-store context. When a user
        // switches to overview while on /scans, send them to the dashboard.
        if ($storeId === null && $this->isOnScansArea($request)) {
            return to_route('dealer.dashboard');
        }

        return back();
    }

    private function isOnScansArea(SwitchStoreRequest $request): bool
    {
        $referer = (string) $request->headers->get('referer');

        if ($referer === '') {
            return false;
        }

        $path = parse_url($referer, PHP_URL_PATH);

        if (! is_string($path)) {
            return false;
        }

        return str_starts_with($path, '/scans');
    }
}
