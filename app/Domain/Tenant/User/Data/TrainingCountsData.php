<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Data;

use Illuminate\Support\Collection;

final readonly class TrainingCountsData
{
    public function __construct(
        public int $employees,
        public int $compliant,
        public int $atRisk,
        public int $overdue,
        public int $unassigned,
        public int $incompleteCourses,
        public int $expiredCourses,
        public int $expiringSoonCourses,
    ) {}

    /**
     * @param  Collection<int, TrainingSummaryData>  $summaries
     */
    public static function fromSummaries(Collection $summaries): self
    {
        $totals = $summaries->reduce(
            static function (array $carry, TrainingSummaryData $summary): array {
                $carry['employees']++;
                $carry[$summary->status]++;
                $carry['incomplete_courses'] += $summary->notCompleted;
                $carry['expired_courses'] += $summary->expired;
                $carry['expiring_soon_courses'] += $summary->expiringSoon;

                return $carry;
            },
            [
                'employees' => 0,
                'compliant' => 0,
                'at_risk' => 0,
                'overdue' => 0,
                'unassigned' => 0,
                'incomplete_courses' => 0,
                'expired_courses' => 0,
                'expiring_soon_courses' => 0,
            ],
        );

        return new self(
            employees: $totals['employees'],
            compliant: $totals['compliant'],
            atRisk: $totals['at_risk'],
            overdue: $totals['overdue'],
            unassigned: $totals['unassigned'],
            incompleteCourses: $totals['incomplete_courses'],
            expiredCourses: $totals['expired_courses'],
            expiringSoonCourses: $totals['expiring_soon_courses'],
        );
    }

    /**
     * @return array{
     *     employees: int,
     *     compliant: int,
     *     at_risk: int,
     *     overdue: int,
     *     unassigned: int,
     *     incomplete_courses: int,
     *     expired_courses: int,
     *     expiring_soon_courses: int
     * }
     */
    public function toArray(): array
    {
        return [
            'employees' => $this->employees,
            'compliant' => $this->compliant,
            'at_risk' => $this->atRisk,
            'overdue' => $this->overdue,
            'unassigned' => $this->unassigned,
            'incomplete_courses' => $this->incompleteCourses,
            'expired_courses' => $this->expiredCourses,
            'expiring_soon_courses' => $this->expiringSoonCourses,
        ];
    }
}
