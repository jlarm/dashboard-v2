<?php

declare(strict_types=1);

use App\Domain\Tenant\Audits\Queries\BuildAuditChartData;
use Carbon\CarbonImmutable;

function violationAudit(string $date, string $grade, int $violations, int $remediations): object
{
    return new class(CarbonImmutable::parse($date), $grade, $violations, $remediations)
    {
        public function __construct(
            public readonly CarbonImmutable $date,
            public readonly string $grade,
            public readonly int $violation_count,
            public readonly int $remediation_count,
        ) {}
    };
}

function legacyAuditWithoutViolations(string $date, ?string $grade): object
{
    return new class(CarbonImmutable::parse($date), $grade)
    {
        public function __construct(
            public readonly CarbonImmutable $audit_date,
            public readonly ?string $grade,
        ) {}
    };
}

it('formats violation audits into chart points sorted ascending', function (): void {
    $result = (new BuildAuditChartData())->handle(
        violationAudits: [
            violationAudit('2024-01-15', 'A', 3, 2),
            violationAudit('2024-04-10', 'B', 5, 1),
        ],
        legacyAudits: [],
    );

    expect($result['labels'])->toBe(["Jan '24", "Apr '24"])
        ->and($result['gradesLetters'])->toBe(['A', 'B'])
        ->and($result['gradesNumeric'])->toBe([4, 3])
        ->and($result['violations'])->toBe([3, 5])
        ->and($result['remediations'])->toBe([2, 1]);
});

it('keeps only the four most recent audits but sorts them ascending', function (): void {
    $result = (new BuildAuditChartData())->handle(
        violationAudits: [
            violationAudit('2024-01-01', 'A', 1, 0),
            violationAudit('2024-02-01', 'B', 2, 0),
            violationAudit('2024-03-01', 'C', 3, 0),
            violationAudit('2024-04-01', 'D', 4, 0),
            violationAudit('2024-05-01', 'F', 5, 0),
        ],
        legacyAudits: [],
    );

    expect($result['labels'])->toBe(["Feb '24", "Mar '24", "Apr '24", "May '24"])
        ->and($result['gradesLetters'])->toBe(['B', 'C', 'D', 'F'])
        ->and($result['gradesNumeric'])->toBe([3, 2, 1, 0]);
});

it('skips audits missing a date or grade', function (): void {
    $audits = [
        violationAudit('2024-01-15', 'A', 1, 1),
        new class
        {
            public ?CarbonImmutable $date = null;
            public string $grade = 'A';
            public int $violation_count = 0;
            public int $remediation_count = 0;
        },
        new class
        {
            public CarbonImmutable $date;
            public ?string $grade = null;
            public int $violation_count = 0;
            public int $remediation_count = 0;

            public function __construct()
            {
                $this->date = CarbonImmutable::parse('2024-02-01');
            }
        },
    ];

    $result = (new BuildAuditChartData())->handle($audits, []);

    expect($result['labels'])->toBe(["Jan '24"])
        ->and($result['gradesLetters'])->toBe(['A']);
});

it('treats legacy audits without a violations relation as zero violations', function (): void {
    $result = (new BuildAuditChartData())->handle(
        violationAudits: [],
        legacyAudits: [
            legacyAuditWithoutViolations('2024-03-01', 'B'),
        ],
    );

    expect($result['labels'])->toBe(["Mar '24"])
        ->and($result['gradesLetters'])->toBe(['B'])
        ->and($result['violations'])->toBe([0])
        ->and($result['remediations'])->toBe([0]);
});

it('counts pre-loaded legacy violations when the relation is loaded', function (): void {
    $audit = new class
    {
        public CarbonImmutable $audit_date;
        public string $grade = 'A';
        public Illuminate\Support\Collection $violations;

        public function __construct()
        {
            $this->audit_date = CarbonImmutable::parse('2024-06-01');
            $this->violations = collect([(object) [], (object) [], (object) []]);
        }

        public function violations()
        {
            return $this->violations;
        }

        public function relationLoaded(string $name): bool
        {
            return $name === 'violations';
        }
    };

    $result = (new BuildAuditChartData())->handle([], [$audit]);

    expect($result['violations'])->toBe([3]);
});

it('lower-cases grades safely and falls back to zero on unknown letters', function (): void {
    $result = (new BuildAuditChartData())->handle(
        violationAudits: [
            violationAudit('2024-01-01', 'a', 0, 0),
            violationAudit('2024-02-01', 'Z', 0, 0),
        ],
        legacyAudits: [],
    );

    expect($result['gradesLetters'])->toBe(['A', 'Z'])
        ->and($result['gradesNumeric'])->toBe([4, 0]);
});
