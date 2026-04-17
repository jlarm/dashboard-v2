<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Course;
use App\Models\User;
use App\Services\UserCourseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CourseController extends Controller
{
    private const array STATE_ALIASES = [
        'al' => 'alabama',
        'ak' => 'alaska',
        'az' => 'arizona',
        'ar' => 'arkansas',
        'ca' => 'california',
        'co' => 'colorado',
        'ct' => 'connecticut',
        'de' => 'delaware',
        'fl' => 'florida',
        'ga' => 'georgia',
        'hi' => 'hawaii',
        'id' => 'idaho',
        'il' => 'illinois',
        'in' => 'indiana',
        'ia' => 'iowa',
        'ks' => 'kansas',
        'ky' => 'kentucky',
        'la' => 'louisiana',
        'me' => 'maine',
        'md' => 'maryland',
        'ma' => 'massachusetts',
        'mi' => 'michigan',
        'mn' => 'minnesota',
        'ms' => 'mississippi',
        'mo' => 'missouri',
        'mt' => 'montana',
        'ne' => 'nebraska',
        'nv' => 'nevada',
        'nh' => 'new hampshire',
        'nj' => 'new jersey',
        'nm' => 'new mexico',
        'ny' => 'new york',
        'nc' => 'north carolina',
        'nd' => 'north dakota',
        'oh' => 'ohio',
        'ok' => 'oklahoma',
        'or' => 'oregon',
        'pa' => 'pennsylvania',
        'ri' => 'rhode island',
        'sc' => 'south carolina',
        'sd' => 'south dakota',
        'tn' => 'tennessee',
        'tx' => 'texas',
        'ut' => 'utah',
        'vt' => 'vermont',
        'va' => 'virginia',
        'wa' => 'washington',
        'wv' => 'west virginia',
        'wi' => 'wisconsin',
        'wy' => 'wyoming',
    ];

    public function show(Course $course): View|RedirectResponse
    {
        $replacementCourse = $this->resolveReplacementCourse($course);

        if ($replacementCourse instanceof Course) {
            return to_route('dealer.courses.show', $replacementCourse);
        }

        return view('dealer.course.show', [
            'course' => $course,
        ]);
    }

    public function quiz(Course $course): View|RedirectResponse
    {
        $replacementCourse = $this->resolveReplacementCourse($course);

        if ($replacementCourse instanceof Course) {
            return to_route('dealer.courses.quiz', $replacementCourse);
        }

        return view('dealer.course.quiz', [
            'course' => $course,
        ]);
    }

    public function edit(Course $course): View
    {
        return view('dealer.course.edit', [
            'course' => $course,
        ]);
    }

    private function resolveReplacementCourse(Course $course): ?Course
    {
        $user = auth()->user();
        if (! $user instanceof User) {
            return null;
        }

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        if ($courseIds === []) {
            return null;
        }

        $assignedCourses = Course::query()
            ->whereIn('id', $courseIds)
            ->get(['id', 'slug', 'replaces_course_slugs']);

        $replacementCourse = $assignedCourses->first(
            fn (Course $candidate): bool => in_array($course->slug, $candidate->replaces_course_slugs ?? [], true)
        );

        if ($replacementCourse instanceof Course && $replacementCourse->id !== $course->id) {
            return $replacementCourse;
        }

        $userStates = collect(
            $user->relationLoaded('stores')
                ? $user->stores->pluck('state')->all()
                : $user->stores()->pluck('state')->all()
        )
            ->map(fn (mixed $state): string => $this->normalizeState((string) $state))
            ->filter()
            ->unique()
            ->values();

        if ($userStates->isEmpty()) {
            return null;
        }

        $stateReplacementCourse = Course::query()
            ->whereNotNull('states_required')
            ->whereJsonContains('replaces_course_slugs', $course->slug)
            ->get(['id', 'slug', 'states_required'])
            ->first(function (Course $candidate) use ($userStates): bool {
                $requiredStates = collect($candidate->states_required ?? [])
                    ->map(fn (mixed $state): string => $this->normalizeState((string) $state))
                    ->filter()
                    ->unique()
                    ->values();

                return $requiredStates->intersect($userStates)->isNotEmpty();
            });

        if ($stateReplacementCourse instanceof Course && $stateReplacementCourse->id !== $course->id) {
            return $stateReplacementCourse;
        }

        return null;
    }

    private function normalizeState(string $state): string
    {
        $normalized = mb_strtolower(mb_trim($state));
        if ($normalized === '') {
            return '';
        }

        return self::STATE_ALIASES[$normalized] ?? $normalized;
    }
}
