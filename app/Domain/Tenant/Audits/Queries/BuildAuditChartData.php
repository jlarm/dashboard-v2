<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Queries;

use Illuminate\Support\Collection;

class BuildAuditChartData
{
    private const GRADE_MAP = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];

    /**
     * @param  iterable<object>  $violationAudits  Models exposing date, grade, violation_count, remediation_count
     * @param  iterable<object>  $legacyAudits  Legacy *Audit models exposing audit_date, grade; Osha exposes a violations() morph, BodyShop/Finance do not
     * @return array{labels: array<string>, gradesNumeric: array<int>, gradesLetters: array<string>, violations: array<int>, remediations: array<int>}
     */
    public function handle(iterable $violationAudits, iterable $legacyAudits): array
    {
        $points = collect();

        foreach ($violationAudits as $audit) {
            if ($audit->date && $audit->grade) {
                $points->push([
                    'date' => $audit->date,
                    'grade' => $audit->grade,
                    'violations' => (int) ($audit->violation_count ?? 0),
                    'remediations' => (int) ($audit->remediation_count ?? 0),
                ]);
            }
        }

        foreach ($legacyAudits as $audit) {
            if ($audit->audit_date && $audit->grade !== null) {
                $points->push([
                    'date' => $audit->audit_date,
                    'grade' => $audit->grade,
                    'violations' => $this->legacyViolationCount($audit),
                    'remediations' => 0,
                ]);
            }
        }

        $sorted = $points->sortByDesc('date')->take(4)->sortBy('date')->values();

        return [
            'labels' => $sorted->map(fn (array $point): string => $point['date']->format('M \'y'))->toArray(),
            'gradesNumeric' => $sorted->map(fn (array $point): int => self::GRADE_MAP[mb_strtoupper((string) $point['grade'])] ?? 0)->all(),
            'gradesLetters' => $sorted->map(fn (array $point): string => mb_strtoupper((string) $point['grade']))->all(),
            'violations' => $sorted->map(fn (array $point): int => (int) $point['violations'])->toArray(),
            'remediations' => $sorted->map(fn (array $point): int => (int) $point['remediations'])->toArray(),
        ];
    }

    private function legacyViolationCount(object $audit): int
    {
        if (! method_exists($audit, 'violations')) {
            return 0;
        }

        if (method_exists($audit, 'relationLoaded') && $audit->relationLoaded('violations')) {
            $loaded = $audit->violations;

            return $loaded instanceof Collection ? $loaded->count() : (int) (is_countable($loaded) ? count($loaded) : 0);
        }

        return $audit->violations()->count();
    }
}
