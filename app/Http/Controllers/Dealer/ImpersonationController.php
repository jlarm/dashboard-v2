<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class ImpersonationController extends Controller
{
    public function impersonate(User $user): RedirectResponse
    {
        abort_unless(auth()->user()->can('impersonate-users'), 403, 'You do not have permission to impersonate users.');

        // Don't allow impersonating yourself
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot impersonate yourself.');
        }

        // Generate impersonation token
        $token = tenancy()->impersonate(
            tenant(), // Current tenant
            $user->id,
            '/dashboard', // Redirect URL after successful impersonation
            'web' // Auth guard
        );

        // Get current domain
        $domain = request()->getHost();

        // Redirect to the impersonation route
        return redirect("https://{$domain}/impersonate/{$token->token}");
    }

    public function stopImpersonation(): RedirectResponse
    {
        // Check if user is being impersonated
        if (! session()->has('impersonated_by')) {
            return redirect()->back();
        }

        // Get the original user ID
        $originalUserId = session('impersonated_by');

        // Clear the impersonation session
        session()->forget('impersonated_by');

        // Logout the impersonated user
        auth()->logout();

        // Login as the original user
        auth()->loginUsingId($originalUserId);

        return redirect('/dashboard')->with('success', 'Returned to your account.');
    }
}
