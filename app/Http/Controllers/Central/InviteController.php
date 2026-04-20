<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\User\Actions\CreateInviteAction;
use App\Domain\Central\User\Data\CreateInviteData;
use App\Domain\Central\UserInvite\Queries\GetUserInvites;
use App\Http\Controllers\Controller;
use App\Http\Requests\Central\User\StoreInviteRequest;
use App\Http\Resources\Central\UserInviteResource;
use App\Models\Central\UserInvite;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class InviteController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(UserInvite::class, 'invite');
    }

    public function index(GetUserInvites $getUserInvites): Response
    {
        return Inertia::render('central/user/Invites', [
            'openInvites' => UserInviteResource::collection($getUserInvites->handle()),
        ]);
    }

    public function store(
        StoreInviteRequest $request,
        CreateInviteAction $createInvite
    ): RedirectResponse {
        $validated = $request->validated();

        $createInvite->execute(
            data: new CreateInviteData(
                name: $validated['name'],
                email: $validated['email'],
            ),
            inviterId: $request->user()->id,
        );

        Inertia::flash('success', 'Invite sent successfully.');

        return back();
    }

    public function destroy(UserInvite $invite): RedirectResponse
    {
        $invite->delete();

        Inertia::flash('success', 'Invite deleted successfully.');

        return back();
    }
}
