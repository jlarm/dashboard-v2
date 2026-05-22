<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Queries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BuildAuditChartData
{
    private const array GRADE_MAP = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];

    /**
     * @param  iterable<Model>  $violationAudits  Models exposing date, grade, violation_count, remediation_count
     * @param  iterable<Model>  $legacyAudits  Legacy *Audit models exposing audit_date, grade; Osha exposes a violations() morph, BodyShop/Finance do not
     * @return array{labels: array<string>, gradesNumeric: array<int>, gradesLetters: array<string>, violations: array<int>, remediations: array<int>}
     */
    public function handle(iterable $violationAudits, iterable $legacyAudits): array
    {
        $points = collect();

        foreach ($violationAudits as $audit) {
            $date = $audit->getAttribute('date');
            $grade = $audit->getAttribute('grade');

            if ($date && $grade) {
                $points->push([
                    'date' => $date,
                    'grade' => $grade,
                    'violations' => (int) ($audit->getAttribute('violation_count') ?? 0),
                    'remediations' => (int) ($audit->getAttribute('remediation_count') ?? 0),
                ]);
            }
        }

        foreach ($legacyAudits as $audit) {
            $date = $audit->getAttribute('audit_date');
            $grade = $audit->getAttribute('grade');

            if ($date && $grade !== null) {
                $points->push([
                    'date' => $date,
                    'grade' => $grade,
                    'violations' => $this->legacyViolationCount($audit),
                    'remediations' => 0,
                ]);
            }
        }

        $sorted = $points->sortByDesc('date')->take(4)->sortBy('date')->values();

        return [
            'labels' => $sorted->map(fn (array $point): string => $point['date']->format('M \'y'))->all(),
            'gradesNumeric' => $sorted->map(fn (array $point): int => self::GRADE_MAP[mb_strtoupper((string) $point['grade'])] ?? 0)->all(),
            'gradesLetters' => $sorted->map(fn (array $point): string => mb_strtoupper((string) $point['grade']))->all(),
            'violations' => $sorted->map(fn (array $point): int => (int) $point['violations'])->all(),
            'remediations' => $sorted->map(fn (array $point): int => (int) $point['remediations'])->all(),
        ];
    }

    private function legacyViolationCount(Model $audit): int
    {
        if (! method_exists($audit, 'violations')) {
            return 0;
        }

        if ($audit->relationLoaded('violations')) {
            $loaded = $audit->getAttribute('violations');

            return ($loaded instanceof Collection ? $loaded->count() : is_countable($loaded)) ? count($loaded) : 0;
        }

        return $audit->violations()->count();
    }
}
