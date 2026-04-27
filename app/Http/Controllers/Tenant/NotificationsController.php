<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function markAsRead(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        $this->authorizeOwnership($request, $notification);

        $notification->markAsRead();

        return back();
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $user->unreadNotifications()->update(['read_at' => now()]);

        return back();
    }

    public function destroy(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        $this->authorizeOwnership($request, $notification);

        $notification->delete();

        return back();
    }

    private function authorizeOwnership(Request $request, DatabaseNotification $notification): void
    {
        /** @var User|null $user */
        $user = $request->user();

        abort_unless(
            $user instanceof User
            && $notification->notifiable_type === $user::class
            && (int) $notification->notifiable_id === (int) $user->id,
            404,
        );
    }
}
