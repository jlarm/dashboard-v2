<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Domain\Tenant\User\Actions\RegisterInvitedEmployee;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\User\RegisterInvitedEmployeeRequest;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    private const string SECTION_COURSES = 'courses';

    private const string SECTION_MANAGE_COURSES = 'manage-courses';

    private const string SECTION_CERTIFICATES = 'certificates';

    private const string SECTION_VIDEO_PROGRESS = 'video-progress';

    public function show(User $user): View
    {
        return $this->renderSection($user, self::SECTION_COURSES);
    }

    public function showManageCourses(User $user): View
    {
        return $this->renderSection($user, self::SECTION_MANAGE_COURSES);
    }

    public function showCertificates(User $user): View
    {
        return $this->renderSection($user, self::SECTION_CERTIFICATES);
    }

    public function showVideoProgress(User $user): View
    {
        return $this->renderSection($user, self::SECTION_VIDEO_PROGRESS);
    }

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

    private function authorizeUserVisibility(User $user): void
    {
        $viewer = auth()->user();

        abort_unless($viewer instanceof User, 403);

        if ($viewer->hasAnyRole(['super-admin', 'Consultant'])) {
            return;
        }

        $viewerStoreIds = $viewer->stores()->pluck('stores.id');

        abort_if($viewerStoreIds->isEmpty(), 403);

        $isInVisibleStore = $user->stores()
            ->whereIn('stores.id', $viewerStoreIds)
            ->exists();

        abort_unless($isInVisibleStore, 403);
    }

    private function renderSection(User $user, string $section): View
    {
        $this->authorizeUserVisibility($user);

        abort_if($section === self::SECTION_MANAGE_COURSES && ! $this->canManageCourses(), 403);

        $user->load('department', 'roles');

        $isQi = $user->roles->contains('name', 'Qualified Individual');
        $roles = $user->roles->whereNotIn('name', ['Qualified Individual'])->pluck('name')->toArray();

        $store = Store::query()
            ->select(['id', 'videos'])
            ->find((int) resolve('currentStore'));

        $videosActive = (bool) ($store?->videos ?? false);

        abort_if($section === self::SECTION_VIDEO_PROGRESS && ! $videosActive, 404);

        return view('dealer.employee.show', [
            'user' => $user,
            'isQi' => $isQi,
            'roles' => $roles,
            'videosActive' => $videosActive,
            'section' => $section,
            'canManageCourses' => $this->canManageCourses(),
        ]);
    }

    private function canManageCourses(): bool
    {
        $viewer = auth()->user();

        return $viewer instanceof User
            && $viewer->hasAnyRole(['super-admin', 'Consultant', 'Qualified Individual']);
    }
}
