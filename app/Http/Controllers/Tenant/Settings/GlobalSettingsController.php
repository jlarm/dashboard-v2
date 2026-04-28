<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Settings\ResetCoursesRequest;
use App\Http\Requests\Tenant\Settings\UpdatePhishingSettingsRequest;
use App\Jobs\SendCoursesResetNotifications;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\CourseResetService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class GlobalSettingsController extends Controller
{
    private const string SECTION_GENERAL = 'general';

    private const string SECTION_COURSE_MANAGEMENT = 'course-management';

    private const string SECTION_RESET_COURSES = 'reset-courses';

    private const string SECTION_PHISHING = 'phishing';

    private const array SECTIONS = [
        self::SECTION_GENERAL,
        self::SECTION_COURSE_MANAGEMENT,
        self::SECTION_RESET_COURSES,
        self::SECTION_PHISHING,
    ];

    public function index(Request $request): InertiaResponse
    {
        $this->authorize('manage', GlobalSetting::class);

        $section = $request->route()->defaults['section'] ?? self::SECTION_GENERAL;
        abort_unless(is_string($section) && in_array($section, self::SECTIONS, true), 404);

        $settings = GlobalSetting::query()->first();

        return Inertia::render('tenant/settings/GlobalSettings', [
            'section' => $section,
            'phishing' => [
                'active' => (bool) ($settings?->phishing_active ?? false),
                'token' => $settings?->phishing_token,
                'ip' => $settings?->phishing_ip,
            ],
            'stores' => $this->stores(),
            'courses' => $this->courses(),
            'search' => (string) $request->string('search'),
            'users' => $section === self::SECTION_RESET_COURSES
                ? $this->resettableUsers((string) $request->string('search'))
                : [],
        ]);
    }

    public function updatePhishing(UpdatePhishingSettingsRequest $request): RedirectResponse
    {
        GlobalSetting::query()->updateOrCreate([], [
            'phishing_active' => $request->boolean('phishing_active'),
            'phishing_token' => $request->validated('phishing_token'),
            'phishing_ip' => $request->validated('phishing_ip'),
        ]);

        return back()->with('flash.success', 'Phishing settings updated.');
    }

    public function toggleStoreNotifications(Store $store): RedirectResponse
    {
        $this->authorize('manage', GlobalSetting::class);

        $store->update([
            'courses_not_taken_notification' => ! $store->courses_not_taken_notification,
        ]);

        return back();
    }

    public function toggleStoreRemediations(Store $store): RedirectResponse
    {
        $this->authorize('manage', GlobalSetting::class);

        $current = (bool) $store->remediationSettings?->active;

        $store->remediationSettings()->updateOrCreate([], ['active' => ! $current]);

        return back();
    }

    public function toggleOptionalCourse(Course $course): RedirectResponse
    {
        $this->authorize('manage', GlobalSetting::class);

        $course->update(['optional' => ! $course->optional]);

        return back();
    }

    public function resetCourses(ResetCoursesRequest $request): RedirectResponse
    {
        $mode = $request->validated('mode');
        $selectedUserIds = collect($request->validated('user_ids', []))
            ->map(static fn ($userId): int => (int) $userId)
            ->filter()
            ->unique()
            ->values();

        $userIdsForReset = $mode === 'selected-users'
            ? $selectedUserIds
            : $this->allResettableUserIds();

        $affectedUserIds = resolve(CourseResetService::class)->reset(
            store: null,
            selectedUserIds: $userIdsForReset,
        );

        $this->logCourseReset($mode, $selectedUserIds, $affectedUserIds);

        if ($affectedUserIds->isNotEmpty()) {
            dispatch(new SendCoursesResetNotifications($affectedUserIds, tenant()->name));
        }

        $message = $mode === 'selected-users'
            ? 'Selected courses reset successfully.'
            : 'Courses reset successfully.';

        return back()->with('flash.success', $message);
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function stores(): array
    {
        return Store::query()
            ->with('remediationSettings:id,store_id,active')
            ->orderBy('name')
            ->get(['id', 'name', 'courses_not_taken_notification'])
            ->map(static fn (Store $store): array => [
                'id' => $store->id,
                'name' => $store->name,
                'courses_not_taken_notification' => (bool) $store->courses_not_taken_notification,
                'remediations_active' => (bool) ($store->remediationSettings?->active ?? false),
            ])
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function courses(): array
    {
        return Course::query()
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'optional'])
            ->map(static fn (Course $course): array => [
                'id' => $course->id,
                'name' => $course->name,
                'slug' => $course->slug,
                'optional' => (bool) $course->optional,
            ])
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function resettableUsers(string $search): array
    {
        return $this->resettableUsersQuery($search)
            ->get()
            ->map(static function (User $user): array {
                $totalUserCourses = (int) ($user->total_user_courses ?? 0);
                $totalCompletedCourses = (int) ($user->total_completed_courses ?? 0);
                $resultsCount = (int) ($user->results_count ?? 0);

                $status = 'not-started';
                if ($totalUserCourses > 0 && $totalCompletedCourses === $totalUserCourses) {
                    $status = 'completed';
                } elseif ($resultsCount > 0) {
                    $status = 'in-progress';
                }

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'stores' => $user->stores->pluck('name')->all(),
                    'status' => $status,
                ];
            })
            ->all();
    }

    private function resettableUsersQuery(string $search): Builder
    {
        $searchTerm = mb_trim($search);

        return User::query()
            ->withoutSuperAdminsAndConsultants()
            ->with([
                'roles:id,name',
                'stores:id,name,state',
                'courseOverrides:user_id,course_id,type',
                'results:id,user_id,course_id,passed,created_at',
            ])
            ->withCount('results')
            ->select(['id', 'name', 'email', 'department_id'])
            ->when($searchTerm !== '', function (Builder $query) use ($searchTerm): void {
                $like = '%'.$searchTerm.'%';

                $query->where(function (Builder $inner) use ($like): void {
                    $inner->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhereHas('stores', function (Builder $storeQuery) use ($like): void {
                            $storeQuery->where('name', 'like', $like);
                        });
                });
            })
            ->orderBy('name');
    }

    private function allResettableUserIds(): Collection
    {
        return CourseResults::query()
            ->distinct()
            ->pluck('user_id')
            ->map(static fn ($userId): int => (int) $userId)
            ->filter()
            ->unique()
            ->values();
    }

    private function logCourseReset(string $mode, Collection $selectedUserIds, Collection $affectedUserIds): void
    {
        $description = $mode === 'selected-users'
            ? 'Course results reset for selected users'
            : 'All employee course results reset';

        $properties = [
            'reset_scope' => $mode === 'selected-users' ? 'selected-users' : 'everyone',
            'selected_user_count' => $selectedUserIds->count(),
            'affected_user_count' => $affectedUserIds->count(),
            'tenant_id' => tenant()?->id,
        ];

        if ($selectedUserIds->isNotEmpty()) {
            $properties['selected_user_ids'] = $selectedUserIds->all();
        }

        activity()
            ->causedBy(auth()->user())
            ->withProperties($properties)
            ->log($description);
    }
}
