<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Domain\Tenant\Store\Queries\GetAccessibleStoreOptions;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
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
            'notifications' => fn (): array => $this->notifications($user),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
                'info' => fn () => $request->session()->get('info'),
                'message' => fn () => $request->session()->get('message'),
                'quiz' => fn () => $request->session()->get('quiz'),
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

    /**
     * @return array{
     *     items: list<array<string, mixed>>,
     *     unread_count: int
     * }
     */
    private function notifications(?User $user): array
    {
        if (! $user instanceof User || ! tenancy()->initialized) {
            return ['items' => [], 'unread_count' => 0];
        }

        /** @var Collection<int, DatabaseNotification> $notifications */
        $notifications = $user->notifications()
            ->latest()
            ->limit(20)
            ->get();

        return [
            'items' => $notifications
                ->map(static fn (DatabaseNotification $notification): array => [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'data' => $notification->data,
                    'read_at' => $notification->read_at?->toIso8601String(),
                    'created_at' => $notification->created_at?->toIso8601String(),
                    'created_at_relative' => $notification->created_at?->diffForHumans(),
                ])
                ->all(),
            'unread_count' => $user->unreadNotifications()->count(),
        ];
    }
}
