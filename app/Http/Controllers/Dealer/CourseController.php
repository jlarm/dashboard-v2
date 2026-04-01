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
    public function show(Course $course): View|RedirectResponse
    {
        $replacementCourse = $this->resolveReplacementCourse($course);

        if ($replacementCourse instanceof Course) {
            return redirect()->route('dealer.courses.show', $replacementCourse);
        }

        return view('dealer.course.show', [
            'course' => $course,
        ]);
    }

    public function quiz(Course $course): View|RedirectResponse
    {
        $replacementCourse = $this->resolveReplacementCourse($course);

        if ($replacementCourse instanceof Course) {
            return redirect()->route('dealer.courses.quiz', $replacementCourse);
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

        $service = app(UserCourseService::class);
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

        if ($course->slug === 'sexual-harassment-e') {
            $illinoisFallbackCourse = $assignedCourses
                ->filter(
                    fn (Course $candidate): bool => in_array(
                        $candidate->slug,
                        ['sexual-harassment-illinois-m', 'sexual-harassment-illinois'],
                        true
                    )
                )
                ->sortBy(
                    fn (Course $candidate): int => $candidate->slug === 'sexual-harassment-illinois-m' ? 0 : 1
                )
                ->first();

            if ($illinoisFallbackCourse instanceof Course && $illinoisFallbackCourse->id !== $course->id) {
                return $illinoisFallbackCourse;
            }
        }

        return null;
    }
}
