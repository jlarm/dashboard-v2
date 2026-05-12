<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Actions;

use App\Models\Dealer\Course;
use App\Models\User;
use App\Services\UserCourseService;

class ResolveReplacementCourse
{
    public function __construct(private readonly UserCourseService $courseService) {}

    public function handle(Course $course, User $user): ?Course
    {
        $courseIds = $this->courseService->getCourseIds($user);

        if ($courseIds !== []) {
            $assigned = Course::query()
                ->whereIn('id', $courseIds)
                ->get(['id', 'slug', 'replaces_course_slugs']);

            $direct = $assigned->first(
                fn (Course $candidate): bool => in_array($course->slug, $candidate->replaces_course_slugs ?? [], true)
            );

            if ($direct instanceof Course && $direct->id !== $course->id) {
                return $direct;
            }
        }

        $userStates = collect(
            $user->relationLoaded('stores')
                ? $user->stores->pluck('state')->all()
                : $user->stores()->pluck('state')->all()
        )
            ->map(fn (mixed $state): string => $this->courseService->normalizeState((string) $state))
            ->filter()
            ->unique()
            ->values();

        if ($userStates->isEmpty()) {
            return null;
        }

        $stateReplacement = Course::query()
            ->whereNotNull('states_required')
            ->whereJsonContains('replaces_course_slugs', $course->slug)
            ->get(['id', 'slug', 'states_required'])
            ->first(function (Course $candidate) use ($userStates): bool {
                $required = collect($candidate->states_required ?? [])
                    ->map(fn (mixed $state): string => $this->courseService->normalizeState((string) $state))
                    ->filter()
                    ->unique()
                    ->values();

                return $required->intersect($userStates)->isNotEmpty();
            });

        if ($stateReplacement instanceof Course && $stateReplacement->id !== $course->id) {
            return $stateReplacement;
        }

        return null;
    }
}
