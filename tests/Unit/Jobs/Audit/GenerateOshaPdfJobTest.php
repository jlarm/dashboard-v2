<?php

declare(strict_types=1);

use App\Jobs\Audit\GenerateOshaPdfJob;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Violation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

function createViolationWithWeight(int $weight, int $severity): object
{
    $statement = new stdClass();
    $statement->weight = $weight;

    $violation = new stdClass();
    $violation->oshaStatement = $statement;
    $violation->severity = $severity;

    return $violation;
}

function createViolationWithMissingStatement(int $severity): object
{
    $violation = new stdClass();
    $violation->oshaStatement = null;
    $violation->severity = $severity;

    return $violation;
}

function createViolationWithMissingSeverity(int $weight): object
{
    $statement = new stdClass();
    $statement->weight = $weight;

    $violation = new stdClass();
    $violation->oshaStatement = $statement;
    $violation->severity = null;

    return $violation;
}

function invokeRatingMethod(GenerateOshaPdfJob $job): string
{
    $reflection = new ReflectionClass($job);
    $method = $reflection->getMethod('rating');
    $method->setAccessible(true);

    return $method->invoke($job);
}

function createJobWithViolations(array $violationData): GenerateOshaPdfJob
{
    $violations = new Collection();

    foreach ($violationData as $data) {
        $violations->push(createViolationWithWeight($data['weight'], $data['severity']));
    }

    $morphMany = Mockery::mock(MorphMany::class);
    $morphMany->shouldReceive('with')->with('oshaStatement')->andReturnSelf();
    $morphMany->shouldReceive('get')->andReturn($violations);

    $audit = Mockery::mock(OshaViolationAudit::class);
    $audit->shouldReceive('violations')->andReturn($morphMany);

    return new GenerateOshaPdfJob($audit);
}

describe('rating calculation', function () {
    it('returns A grade when there are no violations', function () {
        $job = createJobWithViolations([]);

        expect(invokeRatingMethod($job))->toBe('A');
    });

    it('calculates grade A for minor violations (90%+)', function () {
        // Single minor violation: weight=1, severity=1
        // Penalty = 1 * 0.1 = 0.1
        // Score = (1 - 0.1) / 1 = 90%
        $job = createJobWithViolations([
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeRatingMethod($job))->toBe('A');
    });

    it('calculates grade B for low severity violations (80-89%)', function () {
        // Two violations with higher severity
        // weight=1, severity=2 -> penalty=0.2
        // weight=1, severity=1 -> penalty=0.1
        // Total weight=2, Total penalty=0.3
        // Score = (2 - 0.3) / 2 = 85%
        $job = createJobWithViolations([
            ['weight' => 1, 'severity' => 2],
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeRatingMethod($job))->toBe('B');
    });

    it('calculates grade C for moderate violations (70-79%)', function () {
        // weight=2, severity=3 -> penalty=0.6
        // weight=1, severity=2 -> penalty=0.2
        // weight=1, severity=3 -> penalty=0.3
        // Total weight=4, Total penalty=1.1
        // Score = (4 - 1.1) / 4 = 72.5%
        $job = createJobWithViolations([
            ['weight' => 2, 'severity' => 3],
            ['weight' => 1, 'severity' => 2],
            ['weight' => 1, 'severity' => 3],
        ]);

        expect(invokeRatingMethod($job))->toBe('C');
    });

    it('calculates grade D for higher severity violations (60-69%)', function () {
        // weight=2, severity=4 -> penalty=0.8
        // weight=2, severity=4 -> penalty=0.8
        // weight=1, severity=4 -> penalty=0.4
        // Total weight=5, Total penalty=2.0
        // Score = (5 - 2.0) / 5 = 60%
        $job = createJobWithViolations([
            ['weight' => 2, 'severity' => 4],
            ['weight' => 2, 'severity' => 4],
            ['weight' => 1, 'severity' => 4],
        ]);

        expect(invokeRatingMethod($job))->toBe('D');
    });

    it('calculates grade F for critical violations (<60%)', function () {
        // Single critical violation: weight=5, severity=10
        // Penalty = 5 * 1.0 = 5.0
        // Score = (5 - 5) / 5 = 0%
        $job = createJobWithViolations([
            ['weight' => 5, 'severity' => 10],
        ]);

        expect(invokeRatingMethod($job))->toBe('F');
    });

    it('matches Shop A example: 2 violations with one critical (13.3% = F)', function () {
        // Violation 1: Missing Signage. Weight: 1. Severity: 2
        // Penalty: 1 * 0.2 = 0.2
        // Violation 2: Blocked Fire Exit. Weight: 5. Severity: 10
        // Penalty: 5 * 1.0 = 5.0
        // Total Weight: 6, Total Penalty: 5.2
        // Score: (6 - 5.2) / 6 = 13.3%
        $job = createJobWithViolations([
            ['weight' => 1, 'severity' => 2],
            ['weight' => 5, 'severity' => 10],
        ]);

        expect(invokeRatingMethod($job))->toBe('F');
    });

    it('matches Shop B example: 5 minor violations (88.3% = B)', function () {
        // Violation 1: Dusty floor. Weight: 1. Severity: 1. Penalty: 0.1
        // Violation 2: Lightbulb out. Weight: 1. Severity: 1. Penalty: 0.1
        // Violation 3: Old poster. Weight: 1. Severity: 2. Penalty: 0.2
        // Violation 4: Unlabeled bin. Weight: 2. Severity: 1. Penalty: 0.2
        // Violation 5: Messy desk. Weight: 1. Severity: 1. Penalty: 0.1
        // Total Weight: 6, Total Penalty: 0.7
        // Score: (6 - 0.7) / 6 = 88.3%
        $job = createJobWithViolations([
            ['weight' => 1, 'severity' => 1],
            ['weight' => 1, 'severity' => 1],
            ['weight' => 1, 'severity' => 2],
            ['weight' => 2, 'severity' => 1],
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeRatingMethod($job))->toBe('B');
    });

    it('defaults weight to 1 when statement is missing', function () {
        $violations = new Collection([createViolationWithMissingStatement(1)]);

        $morphMany = Mockery::mock(MorphMany::class);
        $morphMany->shouldReceive('with')->with('oshaStatement')->andReturnSelf();
        $morphMany->shouldReceive('get')->andReturn($violations);

        $audit = Mockery::mock(OshaViolationAudit::class);
        $audit->shouldReceive('violations')->andReturn($morphMany);

        $job = new GenerateOshaPdfJob($audit);

        // Weight defaults to 1, severity=1 -> penalty=0.1
        // Score = (1 - 0.1) / 1 = 90%
        expect(invokeRatingMethod($job))->toBe('A');
    });

    it('defaults severity to 1 when missing', function () {
        $violations = new Collection([createViolationWithMissingSeverity(1)]);

        $morphMany = Mockery::mock(MorphMany::class);
        $morphMany->shouldReceive('with')->with('oshaStatement')->andReturnSelf();
        $morphMany->shouldReceive('get')->andReturn($violations);

        $audit = Mockery::mock(OshaViolationAudit::class);
        $audit->shouldReceive('violations')->andReturn($morphMany);

        $job = new GenerateOshaPdfJob($audit);

        // Weight=1, severity defaults to 1 -> penalty=0.1
        // Score = (1 - 0.1) / 1 = 90%
        expect(invokeRatingMethod($job))->toBe('A');
    });
});

describe('grade boundaries', function () {
    it('returns A at exactly 90%', function () {
        // Need exactly 90%: (weight - penalty) / weight = 0.9
        // With weight=10, severity=1: penalty = 10 * 0.1 = 1
        // Score = (10 - 1) / 10 = 90%
        $job = createJobWithViolations([
            ['weight' => 10, 'severity' => 1],
        ]);

        expect(invokeRatingMethod($job))->toBe('A');
    });

    it('returns B at 89.9%', function () {
        // For 89.9%: need penalty that results in < 90%
        // With weight=100, severity=2: penalty = 100 * 0.2 = 20
        // With weight=1, severity=1: penalty = 1 * 0.1 = 0.1
        // Total weight = 101, Total penalty = 20.1
        // Score = (101 - 20.1) / 101 = 80.1 / 101 = 79.3% -> C
        // Let's use: weight=1000, severity=1 -> penalty=100 -> score=90%
        // Add small extra: weight=10, severity=2 -> penalty=2
        // Total: weight=1010, penalty=102, score=(1010-102)/1010=89.9% -> B
        $job = createJobWithViolations([
            ['weight' => 1000, 'severity' => 1],
            ['weight' => 10, 'severity' => 2],
        ]);

        expect(invokeRatingMethod($job))->toBe('B');
    });

    it('returns B at exactly 80%', function () {
        // 80% score: (weight - penalty) / weight = 0.8
        // With weight=10, severity=2: penalty = 10 * 0.2 = 2
        // Score = (10 - 2) / 10 = 80%
        $job = createJobWithViolations([
            ['weight' => 10, 'severity' => 2],
        ]);

        expect(invokeRatingMethod($job))->toBe('B');
    });

    it('returns C at 79.9%', function () {
        // For 79.9%: need penalty that results in < 80%
        // With weight=1000, severity=2: penalty = 1000 * 0.2 = 200
        // Score = (1000 - 200) / 1000 = 80% -> B (boundary)
        // Add weight=10, severity=1: penalty = 1
        // Total: weight=1010, penalty=201, score=(1010-201)/1010=80.1% -> B
        // We need just under 80%:
        // weight=1000, severity=2: penalty=200, score=80%
        // Add weight=5, severity=1: penalty=0.5
        // Total: weight=1005, penalty=200.5, score=(1005-200.5)/1005=80.05% -> B
        // Need more penalty - use weight=100, severity=3: penalty=30
        // Total: weight=1100, penalty=230, score=(1100-230)/1100=79.1% -> C
        $job = createJobWithViolations([
            ['weight' => 1000, 'severity' => 2],
            ['weight' => 100, 'severity' => 3],
        ]);

        expect(invokeRatingMethod($job))->toBe('C');
    });

    it('returns C at exactly 70%', function () {
        // 70% score: (weight - penalty) / weight = 0.7
        // With weight=10, severity=3: penalty = 10 * 0.3 = 3
        // Score = (10 - 3) / 10 = 70%
        $job = createJobWithViolations([
            ['weight' => 10, 'severity' => 3],
        ]);

        expect(invokeRatingMethod($job))->toBe('C');
    });

    it('returns D at 69.9%', function () {
        // For 69.9%: need penalty that results in < 70%
        // weight=1000, severity=3: penalty=300, score=70%
        // Add weight=10, severity=1: penalty=1
        // Total: weight=1010, penalty=301, score=(1010-301)/1010=70.2% -> C
        // Need more penalty - use weight=100, severity=4: penalty=40
        // Total: weight=1100, penalty=340, score=(1100-340)/1100=69.1% -> D
        $job = createJobWithViolations([
            ['weight' => 1000, 'severity' => 3],
            ['weight' => 100, 'severity' => 4],
        ]);

        expect(invokeRatingMethod($job))->toBe('D');
    });

    it('returns D at exactly 60%', function () {
        // 60% score: (weight - penalty) / weight = 0.6
        // With weight=10, severity=4: penalty = 10 * 0.4 = 4
        // Score = (10 - 4) / 10 = 60%
        $job = createJobWithViolations([
            ['weight' => 10, 'severity' => 4],
        ]);

        expect(invokeRatingMethod($job))->toBe('D');
    });

    it('returns F at 59.9%', function () {
        // For 59.9%: need penalty that results in < 60%
        // weight=1000, severity=4: penalty=400, score=60%
        // Add weight=100, severity=5: penalty=50
        // Total: weight=1100, penalty=450, score=(1100-450)/1100=59.1% -> F
        $job = createJobWithViolations([
            ['weight' => 1000, 'severity' => 4],
            ['weight' => 100, 'severity' => 5],
        ]);

        expect(invokeRatingMethod($job))->toBe('F');
    });
});
