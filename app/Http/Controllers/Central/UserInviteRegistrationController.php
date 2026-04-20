<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Central\User\CompleteInviteRegistrationRequest;
use App\Models\Central\UserInvite;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;

class UserInviteRegistrationController extends Controller
{
    public function create(UserInvite $centralUserInvite): Factory|View
    {
        abort_if($centralUserInvite->isInactive(), 410);

        return view('central.employee.register', [
            'invite' => $centralUserInvite,
        ]);
    }

    public function store(
        CompleteInviteRegistrationRequest $request,
        UserInvite $centralUserInvite
    ): RedirectResponse {
        throw_if($centralUserInvite->isInactive(), GoneHttpException::class, 'This invitation is no longer active.');

        /** @var User $user */
        $user = DB::transaction(function () use ($request, $centralUserInvite): User {
            $invite = UserInvite::query()
                ->lockForUpdate()
                ->findOrFail($centralUserInvite->id);

            throw_if($invite->isInactive(), GoneHttpException::class, 'This invitation is no longer active.');

            if (User::query()->where('email', $invite->email)->exists()) {
                throw ValidationException::withMessages([
                    'email' => 'A user with this email already exists.',
                ]);
            }

            $user = User::query()->create([
                'name' => $invite->name,
                'email' => $invite->email,
                'phone' => $request->validated('phone'),
                'password' => Hash::make($request->validated('password')),
                'email_verified_at' => now(),
            ]);

            $user->assignRole($invite->role);

            $invite->update([
                'accepted_at' => now(),
            ]);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(AppServiceProvider::HOME);
    }
}
