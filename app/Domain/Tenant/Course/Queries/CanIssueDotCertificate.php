<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Queries;

use App\Domain\Tenant\Course\DotCertificate;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;

class CanIssueDotCertificate
{
    public function handle(User $user): bool
    {
        if ($this->alreadyIssued($user)) {
            return false;
        }

        $course = $this->course();
        if (! $course instanceof Course) {
            return false;
        }

        $latest = $this->latestResult($user, $course->id);
        if (! $latest instanceof CourseResults || ! $latest->passed) {
            return false;
        }

        $expires = (int) ($course->years_expires ?? DotCertificate::DEFAULT_YEARS_EXPIRES);

        return $latest->created_at->gte(now()->subYears($expires));
    }

    public function latestPassedResult(User $user): ?CourseResults
    {
        $course = $this->course();
        if (! $course instanceof Course) {
            return null;
        }

        $latest = $this->latestResult($user, $course->id);

        return $latest instanceof CourseResults && $latest->passed ? $latest : null;
    }

    private function course(): ?Course
    {
        return Course::query()
            ->where('slug', DotCertificate::COURSE_SLUG)
            ->first(['id', 'years_expires']);
    }

    private function latestResult(User $user, int $courseId): ?CourseResults
    {
        return CourseResults::query()
            ->where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->latest()
            ->first();
    }

    private function alreadyIssued(User $user): bool
    {
        return $user->certificates()
            ->where('course_name', DotCertificate::COURSE_NAME)
            ->exists();
    }
}
