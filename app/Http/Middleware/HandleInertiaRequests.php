<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Domain\Tenant\Store\Queries\GetAccessibleStoreOptions;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Override;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    #[Override]
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    #[Override]
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $user,
                'roles' => $user?->getRoleNames()->all() ?? [],
                'current_store_id' => $user instanceof User ? $user->current_store_id : null,
                'impersonating' => $request->session()->has('impersonated_by'),
            ],
            'stores' => fn (): array => $this->accessibleStores($user),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
                'info' => fn () => $request->session()->get('info'),
                'message' => fn () => $request->session()->get('message'),
            ],
        ];
    }

    /**
     * @return array<int, array{id: int, name: string}>
     */
    private function accessibleStores(?User $user): array
    {
        if (! $user instanceof User || ! tenancy()->initialized) {
            return [];
        }

        return resolve(GetAccessibleStoreOptions::class)
            ->handle($user)
            ->map(fn ($option): array => $option->toArray())
            ->all();
    }
}
