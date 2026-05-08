<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Settings;

use App\Domain\Tenant\GlobalSettings\Actions\ResetCourses;
use App\Domain\Tenant\GlobalSettings\Actions\ToggleOptionalCourse;
use App\Domain\Tenant\GlobalSettings\Actions\ToggleStoreNotifications;
use App\Domain\Tenant\GlobalSettings\Actions\ToggleStoreRemediations;
use App\Domain\Tenant\GlobalSettings\Actions\UpdatePhishingSettings;
use App\Domain\Tenant\GlobalSettings\Data\CourseSettingData;
use App\Domain\Tenant\GlobalSettings\Data\ResettableUserData;
use App\Domain\Tenant\GlobalSettings\Data\StoreSettingData;
use App\Domain\Tenant\GlobalSettings\Queries\GetCourses;
use App\Domain\Tenant\GlobalSettings\Queries\GetPhishingSettings;
use App\Domain\Tenant\GlobalSettings\Queries\GetResettableUsers;
use App\Domain\Tenant\GlobalSettings\Queries\GetStoreSettings;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Settings\ResetCoursesRequest;
use App\Http\Requests\Tenant\Settings\UpdatePhishingSettingsRequest;
use App\Models\Dealer\Course;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function index(
        Request $request,
        GetStoreSettings $getStoreSettings,
        GetCourses $getCourses,
        GetPhishingSettings $getPhishingSettings,
        GetResettableUsers $getResettableUsers,
    ): InertiaResponse|RedirectResponse {
        $this->authorize('manage', GlobalSetting::class);

        if ($request->user()?->current_store_id !== null) {
            return to_route('dealer.dealer.settings');
        }

        $section = $request->route()->defaults['section'] ?? self::SECTION_GENERAL;
        abort_unless(is_string($section) && in_array($section, self::SECTIONS, true), 404);

        $search = (string) $request->string('search');

        return Inertia::render('tenant/settings/GlobalSettings', [
            'section' => $section,
            'phishing' => $getPhishingSettings->handle()->toArray(),
            'stores' => array_map(
                static fn (StoreSettingData $store): array => $store->toArray(),
                $getStoreSettings->handle(),
            ),
            'courses' => array_map(
                static fn (CourseSettingData $course): array => $course->toArray(),
                $getCourses->handle(),
            ),
            'search' => $search,
            'users' => $section === self::SECTION_RESET_COURSES
                ? array_map(
                    static fn (ResettableUserData $user): array => $user->toArray(),
                    $getResettableUsers->handle($search),
                )
                : [],
        ]);
    }

    public function updatePhishing(UpdatePhishingSettingsRequest $request, UpdatePhishingSettings $updatePhishing): RedirectResponse
    {
        $updatePhishing->handle($request->toData());

        return back()->with('flash.success', 'Phishing settings updated.');
    }

    public function toggleStoreNotifications(Store $store, ToggleStoreNotifications $toggle): RedirectResponse
    {
        $this->authorize('manage', GlobalSetting::class);

        $toggle->handle($store);

        return back();
    }

    public function toggleStoreRemediations(Store $store, ToggleStoreRemediations $toggle): RedirectResponse
    {
        $this->authorize('manage', GlobalSetting::class);

        $toggle->handle($store);

        return back();
    }

    public function toggleOptionalCourse(Course $course, ToggleOptionalCourse $toggle): RedirectResponse
    {
        $this->authorize('manage', GlobalSetting::class);

        $toggle->handle($course);

        return back();
    }

    public function resetCourses(ResetCoursesRequest $request, ResetCourses $resetCourses): RedirectResponse
    {
        $data = $request->toData();

        $resetCourses->handle($data, $request->user());

        $message = $data->isSelectedUsers()
            ? 'Selected courses reset successfully.'
            : 'Courses reset successfully.';

        return back()->with('flash.success', $message);
    }
}
