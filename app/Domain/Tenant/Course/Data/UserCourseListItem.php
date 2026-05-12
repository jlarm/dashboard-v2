<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Data;

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;

class UserCourseListItem
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $status,
        public readonly string $statusLabel,
        public readonly ?int $percentage,
        public readonly ?string $lastTakenAt,
        public readonly bool $hasQuestions,
        public readonly bool $isLocked,
        public readonly ?int $moduleIndex,
    ) {}

    public static function fromCourse(Course $course, ?CourseResults $latest, bool $isLocked, ?int $moduleIndex): self
    {
        [$status, $label, $percentage, $lastTakenAt] = self::resolveStatus($course, $latest);

        return new self(
            id: (int) $course->id,
            name: (string) $course->name,
            slug: (string) $course->slug,
            status: $status,
            statusLabel: $label,
            percentage: $percentage,
            lastTakenAt: $lastTakenAt,
            hasQuestions: is_array($course->questions) && $course->questions !== [],
            isLocked: $isLocked,
            moduleIndex: $moduleIndex,
        );
    }

    /**
     * @return array{
     *     id: int,
     *     name: string,
     *     slug: string,
     *     status: string,
     *     status_label: string,
     *     percentage: ?int,
     *     last_taken_at: ?string,
     *     has_questions: bool,
     *     is_locked: bool,
     *     module_index: ?int,
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status,
            'status_label' => $this->statusLabel,
            'percentage' => $this->percentage,
            'last_taken_at' => $this->lastTakenAt,
            'has_questions' => $this->hasQuestions,
            'is_locked' => $this->isLocked,
            'module_index' => $this->moduleIndex,
        ];
    }

    /**
     * @return array{0: string, 1: string, 2: ?int, 3: ?string}
     */
    private static function resolveStatus(Course $course, ?CourseResults $latest): array
    {
        if (! $latest instanceof CourseResults) {
            return ['never', 'Not taken yet', null, null];
        }

        $yearsExpires = (int) ($course->years_expires ?? 1);
        $expirationDate = $latest->created_at->copy()->addYears($yearsExpires);
        $percentage = (int) $latest->percentage;
        $lastTakenAt = $latest->created_at->format('F d, Y');

        if (! $latest->passed) {
            return ['failed', "Last Attempt: {$lastTakenAt}", $percentage, $lastTakenAt];
        }

        if ($expirationDate->isPast()) {
            return ['expired', 'Retake Required ('.$expirationDate->format('F d, Y').')', $percentage, $lastTakenAt];
        }

        return ['passed', "Passed On: {$lastTakenAt}", $percentage, $lastTakenAt];
    }
}
