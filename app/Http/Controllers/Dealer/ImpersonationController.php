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
        $impersonator = auth()->user();

        abort_unless(
            $impersonator instanceof User && $impersonator->hasAnyRole(['super-admin', 'Consultant']),
            403,
            'Only super-admin and Consultant users can impersonate.'
        );

        // Don't allow impersonating yourself
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot impersonate yourself.');
        }

        // Generate impersonation token
        /** @phpstan-ignore-next-line -- macro provided by stancl/tenancy UserImpersonation feature */
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
            return back();
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
