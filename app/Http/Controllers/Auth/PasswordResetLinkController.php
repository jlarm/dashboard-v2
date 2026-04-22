<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\CrossTenantPasswordResetJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * Always returns the same success response to prevent email enumeration.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = $request->string('email')->toString();

        // Attempt the central reset silently — don't branch on whether the user exists.
        Password::sendResetLink(['email' => $email]);

        // Search every tenant DB for this email and send a tenant-specific reset link.
        dispatch(new CrossTenantPasswordResetJob($email));

        // Always return the same response to prevent email enumeration.
        return back()->with('status', __('passwords.sent'));
    }
}
