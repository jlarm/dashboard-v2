<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class UpdateUserLastLogin
{
    public function handle(Login $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        // ImpersonationMiddleware seeds `impersonated_by` with the admin's id
        // before stancl/tenancy logs in as the target user, so the Login event
        // that fires for the target should not count as a real sign-in.
        if (Session::has('impersonated_by')) {
            return;
        }

        $event->user->forceFill(['last_login_at' => now()])->saveQuietly();
    }
}
