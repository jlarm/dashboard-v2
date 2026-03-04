<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dealer\StoreUserRequest;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Browsershot\Browsershot;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    private const SECTION_COURSES = 'courses';

    private const SECTION_MANAGE_COURSES = 'manage-courses';

    private const SECTION_CERTIFICATES = 'certificates';

    private const SECTION_VIDEO_PROGRESS = 'video-progress';

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

    public function create(Invite $invite): View
    {
        return view('dealer.employee.register', [
            'invite' => $invite,
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $invite = Invite::query()->findOrFail($request->integer('id'));
        $assignedStoreIds = collect(Arr::wrap($invite->stores))
            ->map(static fn ($storeId): int => (int) $storeId)
            ->filter()
            ->unique()
            ->values();

        if ($assignedStoreIds->isEmpty() && Store::query()->count() === 1) {
            $singleStoreId = Store::query()->value('id');

            if ($singleStoreId !== null) {
                $assignedStoreIds = collect([(int) $singleStoreId]);
            }
        }

        // Create user
        $user = User::query()->create([
            'name' => $invite['name'],
            'email' => $invite['email'],
            'department_id' => $invite['department_id'],
            'password' => Hash::make((string) $request->input('password')),
            'current_store_id' => $assignedStoreIds->count() === 1 ? (int) $assignedStoreIds->first() : null,
        ]);

        if ($invite['courses']) {
            foreach ($invite['courses'] as $key => $course) {
                CourseResults::query()->create([
                    'user_id' => $user->id,
                    'course_id' => $key,
                    'percentage' => 100,
                    'passed' => 1,
                    'created_at' => $course.' '.now()->format('H:i:s'),
                    'updated_at' => $course.' '.now()->format('H:i:s'),
                ]);

                $dotCompletion = Course::query()->where('id', $key)->where('slug', 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding')->first() ?? null;

                if ($dotCompletion) {
                    $html = view('dealer.course.CertDownloadView', [
                        'user' => User::query()->where('id', $user->id)->first(),
                        'store' => $request->get('store')?->name ?? tenant('name'),
                        'passed_on' => Carbon::parse($course)->format('F d, Y'),
                    ])->render();

                    $pdf = Browsershot::html($html)->landscape()->pdf();

                    $fileName = Str::slug($user->name).'-'.now()->format('m-d-Y').'-dot-certificate.pdf';

                    Storage::disk('local')->put($fileName, $pdf);

                    $localFile = Storage::disk('local')->get($fileName);

                    Storage::disk('armp-certs')->put(tenant('id').'/'.$user->id.'/'.$fileName, $localFile);

                    Storage::delete($fileName);

                    Certificate::query()->create([
                        'user_id' => $user->id,
                        'course_name' => 'DOT Hazardous Materials Transportation',
                        'file_name' => $fileName,
                    ]);
                }
            }
        }

        if ($assignedStoreIds->isNotEmpty()) {
            $user->stores()->sync($assignedStoreIds->all());
        }

        $user->assignRole(Arr::wrap($invite['roles']));

        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $invite->delete();

        event(new Registered($user));

        $user->markEmailAsVerified();

        Auth::login($user);

        return redirect()->to(RouteServiceProvider::HOME);
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
            ->find((int) app('currentStore'));

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
