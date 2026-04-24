<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Models\Certificate;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class GetEmployeeCertificates
{
    private const string DOT_COURSE_SLUG = 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding';

    private const string DOT_CERTIFICATE_NAME = 'DOT Hazardous Materials Transportation';

    private const int DOT_CERTIFICATE_VALID_DAYS = 1095;

    /**
     * @return list<array{
     *     id: int,
     *     course_name: string,
     *     issued_on: string,
     *     download_url: string
     * }>
     */
    public function certificates(User $user): array
    {
        $tenantId = (string) (tenant('id') ?? '');

        return $user->certificates()
            ->select(['id', 'user_id', 'course_name', 'file_name', 'created_at'])
            ->latest()
            ->get()
            ->map(fn (Certificate $cert): array => [
                'id' => (int) $cert->id,
                'course_name' => (string) $cert->course_name,
                'issued_on' => $cert->created_at?->format('F d, Y') ?? '',
                'download_url' => Storage::disk('armp-certs')->temporaryUrl(
                    "{$tenantId}/{$user->id}/{$cert->file_name}",
                    now()->addMinutes(2),
                ),
            ])
            ->values()
            ->all();
    }

    public function canGenerateDotCertificate(User $user): bool
    {
        $alreadyIssued = $user->certificates()
            ->where('course_name', self::DOT_CERTIFICATE_NAME)
            ->exists();

        if ($alreadyIssued) {
            return false;
        }

        $result = $this->dotCourseResult($user);

        if (! $result instanceof CourseResults || (int) $result->passed !== 1) {
            return false;
        }

        return $result->created_at->diffInDays(now()) <= self::DOT_CERTIFICATE_VALID_DAYS;
    }

    public function dotCourseResult(User $user): ?CourseResults
    {
        $courseId = Course::query()
            ->where('slug', self::DOT_COURSE_SLUG)
            ->latest()
            ->value('id');

        if ($courseId === null) {
            return null;
        }

        return CourseResults::query()
            ->where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->latest()
            ->first();
    }
}
