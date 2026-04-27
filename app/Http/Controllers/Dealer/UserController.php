<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Domain\Tenant\User\Actions\RegisterInvitedEmployee;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\User\RegisterInvitedEmployeeRequest;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Providers\AppServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function create(Invite $invite): Response
    {
        return Inertia::render('tenant/user/Register', [
            'invite' => [
                'id' => $invite->id,
                'name' => $invite->name,
                'email' => $invite->email,
                'company' => (string) tenant('name'),
                'stores' => $this->inviteStoreNames($invite),
            ],
        ]);
    }

    public function store(RegisterInvitedEmployeeRequest $request, RegisterInvitedEmployee $action): RedirectResponse
    {
        $invite = Invite::query()->findOrFail($request->integer('id'));

        $user = $action->handle($invite, $request->password());

        event(new Registered($user));

        Auth::login($user);

        return redirect()->to(AppServiceProvider::HOME);
    }

    /**
     * @return list<string>
     */
    private function inviteStoreNames(Invite $invite): array
    {
        $storeIds = collect($invite->stores ?? [])
            ->map(static fn ($id): int => (int) $id)
            ->filter()
            ->unique()
            ->values();

        if ($storeIds->isEmpty()) {
            return [];
        }

        return Store::query()
            ->whereIn('id', $storeIds)
            ->orderBy('name')
            ->pluck('name')
            ->map(static fn ($name): string => (string) $name)
            ->all();
    }
}
