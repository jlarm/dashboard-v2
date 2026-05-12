<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Queries;

use App\Domain\Tenant\Course\Actions\DispatchDotCertificate;
use App\Models\Certificate;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;

class CanIssueDotCertificate
{
    private const string DOT_SHIPPING_SLUG = 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding';

    public function handle(User $user): bool
    {
        $course = Course::query()
            ->where('slug', self::DOT_SHIPPING_SLUG)
            ->first(['id', 'years_expires']);

        if (! $course instanceof Course) {
            return false;
        }

        $latest = CourseResults::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->latest()
            ->first();

        if (! $latest instanceof CourseResults || ! $latest->passed) {
            return false;
        }

        $expires = (int) ($course->years_expires ?? 3);
        if ($latest->created_at->lt(now()->subYears($expires))) {
            return false;
        }

        return ! Certificate::query()
            ->where('user_id', $user->id)
            ->where('course_name', DispatchDotCertificate::COURSE_NAME)
            ->exists();
    }
}
