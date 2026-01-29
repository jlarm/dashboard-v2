<?php

declare(strict_types=1);

use App\Jobs\Audit\GenerateBodyShopPdfJob;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

function createBodyShopViolation(int $weight, int $severity): object
{
    $statement = new stdClass();
    $statement->weight = $weight;

    $violation = new stdClass();
    $violation->bodyShopStatement = $statement;
    $violation->severity = $severity;

    return $violation;
}

function invokeBodyShopRatingMethod(GenerateBodyShopPdfJob $job): string
{
    $reflection = new ReflectionClass($job);
    $method = $reflection->getMethod('rating');
    $method->setAccessible(true);

    return $method->invoke($job);
}

function createBodyShopJobWithViolations(array $violationData): GenerateBodyShopPdfJob
{
    $violations = new Collection();

    foreach ($violationData as $data) {
        $violations->push(createBodyShopViolation($data['weight'], $data['severity']));
    }

    $morphMany = Mockery::mock(MorphMany::class);
    $morphMany->shouldReceive('with')->with('bodyShopStatement')->andReturnSelf();
    $morphMany->shouldReceive('get')->andReturn($violations);

    $audit = Mockery::mock(BodyShopViolationAudit::class);
    $audit->shouldReceive('violations')->andReturn($morphMany);

    return new GenerateBodyShopPdfJob($audit);
}

describe('Body Shop rating calculation', function () {
    it('returns A grade when there are no violations', function () {
        $job = createBodyShopJobWithViolations([]);

        expect(invokeBodyShopRatingMethod($job))->toBe('A');
    });

    it('calculates grade A for minor violations (90%+)', function () {
        $job = createBodyShopJobWithViolations([
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('A');
    });

    it('calculates grade B for low severity violations (80-89%)', function () {
        $job = createBodyShopJobWithViolations([
            ['weight' => 1, 'severity' => 2],
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('B');
    });

    it('calculates grade C for moderate violations (70-79%)', function () {
        $job = createBodyShopJobWithViolations([
            ['weight' => 2, 'severity' => 3],
            ['weight' => 1, 'severity' => 2],
            ['weight' => 1, 'severity' => 3],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('C');
    });

    it('calculates grade D for higher severity violations (60-69%)', function () {
        $job = createBodyShopJobWithViolations([
            ['weight' => 2, 'severity' => 4],
            ['weight' => 2, 'severity' => 4],
            ['weight' => 1, 'severity' => 4],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('D');
    });

    it('calculates grade F for critical violations (<60%)', function () {
        $job = createBodyShopJobWithViolations([
            ['weight' => 5, 'severity' => 10],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('F');
    });

    it('weighs critical violations heavily even with few total violations', function () {
        // 2 violations: one minor, one critical
        // Weight: 1+5=6, Penalty: 0.2+5.0=5.2
        // Score: (6-5.2)/6 = 13.3% = F
        $job = createBodyShopJobWithViolations([
            ['weight' => 1, 'severity' => 2],
            ['weight' => 5, 'severity' => 10],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('F');
    });

    it('scores well with many minor violations', function () {
        // 5 minor violations
        // Weight: 6, Penalty: 0.7
        // Score: (6-0.7)/6 = 88.3% = B
        $job = createBodyShopJobWithViolations([
            ['weight' => 1, 'severity' => 1],
            ['weight' => 1, 'severity' => 1],
            ['weight' => 1, 'severity' => 2],
            ['weight' => 2, 'severity' => 1],
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('B');
    });
});

describe('Body Shop grade boundaries', function () {
    it('returns A at exactly 90%', function () {
        $job = createBodyShopJobWithViolations([
            ['weight' => 10, 'severity' => 1],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('A');
    });

    it('returns B at exactly 80%', function () {
        $job = createBodyShopJobWithViolations([
            ['weight' => 10, 'severity' => 2],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('B');
    });

    it('returns C at exactly 70%', function () {
        $job = createBodyShopJobWithViolations([
            ['weight' => 10, 'severity' => 3],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('C');
    });

    it('returns D at exactly 60%', function () {
        $job = createBodyShopJobWithViolations([
            ['weight' => 10, 'severity' => 4],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('D');
    });

    it('returns F below 60%', function () {
        $job = createBodyShopJobWithViolations([
            ['weight' => 10, 'severity' => 5],
        ]);

        expect(invokeBodyShopRatingMethod($job))->toBe('F');
    });
});
