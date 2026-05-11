<?php

declare(strict_types=1);

use App\Jobs\Audit\GenerateGlbaPdfJob;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Violation;
use App\Models\GlbaViolationStatements;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Stancl\Tenancy\Tenancy;

function createGlbaViolation(int $statementId, int $severity): Violation
{
    $violation = new Violation();
    $violation->statement_id = $statementId;
    $violation->severity = $severity;

    return $violation;
}

function createGlbaStatement(int $id, int $weight): GlbaViolationStatements
{
    $statement = new GlbaViolationStatements();
    $statement->id = $id;
    $statement->weight = $weight;

    return $statement;
}

function invokeGlbaRatingMethod(GenerateGlbaPdfJob $job): string
{
    $reflection = new ReflectionClass($job);
    $method = $reflection->getMethod('rating');

    return $method->invoke($job);
}

function createGlbaJobWithViolations(array $violationData): GenerateGlbaPdfJob
{
    $violations = new Collection();
    $statements = new Collection();

    foreach ($violationData as $index => $data) {
        $statementId = $index + 1;
        $violations->push(createGlbaViolation($statementId, $data['severity']));
        $statements->put($statementId, createGlbaStatement($statementId, $data['weight']));
    }

    $morphMany = Mockery::mock(MorphMany::class);
    $morphMany->shouldReceive('get')->andReturn($violations);

    $audit = Mockery::mock(GlbaViolationAudit::class);
    $audit->shouldReceive('violations')->andReturn($morphMany);

    $tenancy = Mockery::mock(Tenancy::class);
    $tenancy->shouldReceive('central')->andReturnUsing(fn ($callback): Collection => $statements);

    app()->instance(Tenancy::class, $tenancy);

    return new GenerateGlbaPdfJob($audit);
}

beforeEach(function (): void {
    $tenancy = Mockery::mock(Tenancy::class);
    $tenancy->shouldReceive('central')->andReturnUsing(fn ($callback): Collection => new Collection());
    app()->instance(Tenancy::class, $tenancy);
});

describe('GLBA/Finance rating calculation', function (): void {
    it('returns A grade when there are no violations', function (): void {
        $violations = new Collection();

        $morphMany = Mockery::mock(MorphMany::class);
        $morphMany->shouldReceive('get')->andReturn($violations);

        $audit = Mockery::mock(GlbaViolationAudit::class);
        $audit->shouldReceive('violations')->andReturn($morphMany);

        $job = new GenerateGlbaPdfJob($audit);

        expect(invokeGlbaRatingMethod($job))->toBe('A');
    });

    it('calculates grade A for minor violations (90%+)', function (): void {
        $job = createGlbaJobWithViolations([
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('A');
    });

    it('calculates grade B for low severity violations (80-89%)', function (): void {
        $job = createGlbaJobWithViolations([
            ['weight' => 1, 'severity' => 2],
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('B');
    });

    it('calculates grade C for moderate violations (70-79%)', function (): void {
        $job = createGlbaJobWithViolations([
            ['weight' => 2, 'severity' => 3],
            ['weight' => 1, 'severity' => 2],
            ['weight' => 1, 'severity' => 3],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('C');
    });

    it('calculates grade D for higher severity violations (60-69%)', function (): void {
        $job = createGlbaJobWithViolations([
            ['weight' => 2, 'severity' => 4],
            ['weight' => 2, 'severity' => 4],
            ['weight' => 1, 'severity' => 4],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('D');
    });

    it('calculates grade F for critical violations (<60%)', function (): void {
        $job = createGlbaJobWithViolations([
            ['weight' => 5, 'severity' => 10],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('F');
    });

    it('weighs critical violations heavily even with few total violations', function (): void {
        // 2 violations: one minor, one critical
        // Weight: 1+5=6, Penalty: 0.2+5.0=5.2
        // Score: (6-5.2)/6 = 13.3% = F
        $job = createGlbaJobWithViolations([
            ['weight' => 1, 'severity' => 2],
            ['weight' => 5, 'severity' => 10],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('F');
    });

    it('scores well with many minor violations', function (): void {
        // 5 minor violations
        // Weight: 6, Penalty: 0.7
        // Score: (6-0.7)/6 = 88.3% = B
        $job = createGlbaJobWithViolations([
            ['weight' => 1, 'severity' => 1],
            ['weight' => 1, 'severity' => 1],
            ['weight' => 1, 'severity' => 2],
            ['weight' => 2, 'severity' => 1],
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('B');
    });
});

describe('GLBA/Finance grade boundaries', function (): void {
    it('returns A at exactly 90%', function (): void {
        $job = createGlbaJobWithViolations([
            ['weight' => 10, 'severity' => 1],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('A');
    });

    it('returns B at exactly 80%', function (): void {
        $job = createGlbaJobWithViolations([
            ['weight' => 10, 'severity' => 2],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('B');
    });

    it('returns C at exactly 70%', function (): void {
        $job = createGlbaJobWithViolations([
            ['weight' => 10, 'severity' => 3],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('C');
    });

    it('returns D at exactly 60%', function (): void {
        $job = createGlbaJobWithViolations([
            ['weight' => 10, 'severity' => 4],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('D');
    });

    it('returns F below 60%', function (): void {
        $job = createGlbaJobWithViolations([
            ['weight' => 10, 'severity' => 5],
        ]);

        expect(invokeGlbaRatingMethod($job))->toBe('F');
    });
});
