<?php

declare(strict_types=1);

use App\Jobs\Audit\GenerateOshaPdfJob;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Violation;
use App\Models\OshaViolationStatements;
use App\Models\ViolationStatement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Stancl\Tenancy\Tenancy;

function invokeResolveReferenceImages(GenerateOshaPdfJob $job, Collection $violations): array
{
    $reflection = new ReflectionClass($job);
    $method = $reflection->getMethod('resolveReferenceImages');

    return $method->invoke($job, $violations);
}

function makeViolation(int $statementId, bool $showReferenceImage = false): Violation
{
    $violation = new Violation();
    $violation->statement_id = $statementId;
    $violation->show_reference_image = $showReferenceImage;

    return $violation;
}

function makeViolationStatement(int $id, ?string $referenceImageUrl): ViolationStatement
{
    $statement = new ViolationStatement();
    $statement->id = $id;
    $statement->reference_image_url = $referenceImageUrl;

    return $statement;
}

function makeJobForAudit(OshaViolationAudit $audit): GenerateOshaPdfJob
{
    return new GenerateOshaPdfJob($audit);
}

function createViolationWithStatementId(int $statementId, int $severity): object
{
    $violation = new stdClass();
    $violation->statement_id = $statementId;
    $violation->severity = $severity;

    return $violation;
}

function createViolationWithMissingStatementId(int $severity): object
{
    $violation = new stdClass();
    $violation->statement_id = null;
    $violation->severity = $severity;

    return $violation;
}

function createViolationWithMissingSeverity(int $statementId): object
{
    $violation = new stdClass();
    $violation->statement_id = $statementId;
    $violation->severity = null;

    return $violation;
}

function createStatement(int $id, int $weight): OshaViolationStatements
{
    $statement = new OshaViolationStatements();
    $statement->id = $id;
    $statement->weight = $weight;

    return $statement;
}

function invokeRatingMethod(GenerateOshaPdfJob $job): string
{
    $reflection = new ReflectionClass($job);
    $method = $reflection->getMethod('rating');

    return $method->invoke($job);
}

function createJobWithViolationsAndStatements(array $violationData): GenerateOshaPdfJob
{
    $violations = new Collection();
    $statements = new Collection();

    foreach ($violationData as $index => $data) {
        $statementId = $index + 1;
        $violations->push(createViolationWithStatementId($statementId, $data['severity']));
        $statements->put($statementId, createStatement($statementId, $data['weight']));
    }

    $morphMany = Mockery::mock(MorphMany::class);
    $morphMany->shouldReceive('get')->andReturn($violations);

    $audit = Mockery::mock(OshaViolationAudit::class);
    $audit->shouldReceive('violations')->andReturn($morphMany);

    $tenancy = Mockery::mock(Tenancy::class);
    $tenancy->shouldReceive('central')->andReturnUsing(fn ($callback): Collection => $statements);

    app()->instance(Tenancy::class, $tenancy);

    return new GenerateOshaPdfJob($audit);
}

beforeEach(function (): void {
    $tenancy = Mockery::mock(Tenancy::class);
    $tenancy->shouldReceive('central')->andReturnUsing(fn ($callback): Collection => new Collection());
    app()->instance(Tenancy::class, $tenancy);
});

describe('rating calculation', function (): void {
    it('returns A grade when there are no violations', function (): void {
        $violations = new Collection();

        $morphMany = Mockery::mock(MorphMany::class);
        $morphMany->shouldReceive('get')->andReturn($violations);

        $audit = Mockery::mock(OshaViolationAudit::class);
        $audit->shouldReceive('violations')->andReturn($morphMany);

        $job = new GenerateOshaPdfJob($audit);

        expect(invokeRatingMethod($job))->toBe('A');
    });

    it('calculates grade A for minor violations (90%+)', function (): void {
        // Single minor violation: weight=1, severity=1
        // Penalty = 1 * 0.1 = 0.1
        // Score = (1 - 0.1) / 1 = 90%
        $job = createJobWithViolationsAndStatements([
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeRatingMethod($job))->toBe('A');
    });

    it('calculates grade B for low severity violations (80-89%)', function (): void {
        // Two violations with higher severity
        // weight=1, severity=2 -> penalty=0.2
        // weight=1, severity=1 -> penalty=0.1
        // Total weight=2, Total penalty=0.3
        // Score = (2 - 0.3) / 2 = 85%
        $job = createJobWithViolationsAndStatements([
            ['weight' => 1, 'severity' => 2],
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeRatingMethod($job))->toBe('B');
    });

    it('calculates grade C for moderate violations (70-79%)', function (): void {
        // weight=2, severity=3 -> penalty=0.6
        // weight=1, severity=2 -> penalty=0.2
        // weight=1, severity=3 -> penalty=0.3
        // Total weight=4, Total penalty=1.1
        // Score = (4 - 1.1) / 4 = 72.5%
        $job = createJobWithViolationsAndStatements([
            ['weight' => 2, 'severity' => 3],
            ['weight' => 1, 'severity' => 2],
            ['weight' => 1, 'severity' => 3],
        ]);

        expect(invokeRatingMethod($job))->toBe('C');
    });

    it('calculates grade D for higher severity violations (60-69%)', function (): void {
        // weight=2, severity=4 -> penalty=0.8
        // weight=2, severity=4 -> penalty=0.8
        // weight=1, severity=4 -> penalty=0.4
        // Total weight=5, Total penalty=2.0
        // Score = (5 - 2.0) / 5 = 60%
        $job = createJobWithViolationsAndStatements([
            ['weight' => 2, 'severity' => 4],
            ['weight' => 2, 'severity' => 4],
            ['weight' => 1, 'severity' => 4],
        ]);

        expect(invokeRatingMethod($job))->toBe('D');
    });

    it('calculates grade F for critical violations (<60%)', function (): void {
        // Single critical violation: weight=5, severity=10
        // Penalty = 5 * 1.0 = 5.0
        // Score = (5 - 5) / 5 = 0%
        $job = createJobWithViolationsAndStatements([
            ['weight' => 5, 'severity' => 10],
        ]);

        expect(invokeRatingMethod($job))->toBe('F');
    });

    it('matches Shop A example: 2 violations with one critical (13.3% = F)', function (): void {
        // Violation 1: Missing Signage. Weight: 1. Severity: 2
        // Penalty: 1 * 0.2 = 0.2
        // Violation 2: Blocked Fire Exit. Weight: 5. Severity: 10
        // Penalty: 5 * 1.0 = 5.0
        // Total Weight: 6, Total Penalty: 5.2
        // Score: (6 - 5.2) / 6 = 13.3%
        $job = createJobWithViolationsAndStatements([
            ['weight' => 1, 'severity' => 2],
            ['weight' => 5, 'severity' => 10],
        ]);

        expect(invokeRatingMethod($job))->toBe('F');
    });

    it('matches Shop B example: 5 minor violations (88.3% = B)', function (): void {
        // Violation 1: Dusty floor. Weight: 1. Severity: 1. Penalty: 0.1
        // Violation 2: Lightbulb out. Weight: 1. Severity: 1. Penalty: 0.1
        // Violation 3: Old poster. Weight: 1. Severity: 2. Penalty: 0.2
        // Violation 4: Unlabeled bin. Weight: 2. Severity: 1. Penalty: 0.2
        // Violation 5: Messy desk. Weight: 1. Severity: 1. Penalty: 0.1
        // Total Weight: 6, Total Penalty: 0.7
        // Score: (6 - 0.7) / 6 = 88.3%
        $job = createJobWithViolationsAndStatements([
            ['weight' => 1, 'severity' => 1],
            ['weight' => 1, 'severity' => 1],
            ['weight' => 1, 'severity' => 2],
            ['weight' => 2, 'severity' => 1],
            ['weight' => 1, 'severity' => 1],
        ]);

        expect(invokeRatingMethod($job))->toBe('B');
    });

    it('defaults weight to 1 when statement is missing', function (): void {
        $violations = new Collection([createViolationWithMissingStatementId(1)]);

        $morphMany = Mockery::mock(MorphMany::class);
        $morphMany->shouldReceive('get')->andReturn($violations);

        $audit = Mockery::mock(OshaViolationAudit::class);
        $audit->shouldReceive('violations')->andReturn($morphMany);

        $tenancy = Mockery::mock(Tenancy::class);
        $tenancy->shouldReceive('central')->andReturn(new Collection());
        app()->instance(Tenancy::class, $tenancy);

        $job = new GenerateOshaPdfJob($audit);

        // Weight defaults to 1, severity=1 -> penalty=0.1
        // Score = (1 - 0.1) / 1 = 90%
        expect(invokeRatingMethod($job))->toBe('A');
    });

    it('defaults severity to 1 when missing', function (): void {
        $violations = new Collection([createViolationWithMissingSeverity(1)]);
        $statements = new Collection([1 => createStatement(1, 1)]);

        $morphMany = Mockery::mock(MorphMany::class);
        $morphMany->shouldReceive('get')->andReturn($violations);

        $audit = Mockery::mock(OshaViolationAudit::class);
        $audit->shouldReceive('violations')->andReturn($morphMany);

        $tenancy = Mockery::mock(Tenancy::class);
        $tenancy->shouldReceive('central')->andReturn($statements);
        app()->instance(Tenancy::class, $tenancy);

        $job = new GenerateOshaPdfJob($audit);

        // Weight=1, severity defaults to 1 -> penalty=0.1
        // Score = (1 - 0.1) / 1 = 90%
        expect(invokeRatingMethod($job))->toBe('A');
    });
});

describe('resolveReferenceImages', function (): void {
    it('returns an empty array when no violations have show_reference_image enabled', function (): void {
        $audit = Mockery::mock(OshaViolationAudit::class);
        $job = makeJobForAudit($audit);

        $violations = new Collection([
            makeViolation(statementId: 1, showReferenceImage: false),
            makeViolation(statementId: 2, showReferenceImage: false),
        ]);

        expect(invokeResolveReferenceImages($job, $violations))->toBe([]);
    });

    it('returns an empty array when violations collection is empty', function (): void {
        $audit = Mockery::mock(OshaViolationAudit::class);
        $job = makeJobForAudit($audit);

        expect(invokeResolveReferenceImages($job, new Collection()))->toBe([]);
    });

    it('only fetches statement ids for violations with show_reference_image enabled', function (): void {
        $statementWithImage = makeViolationStatement(id: 1, referenceImageUrl: 'https://cdn.example.com/ref.jpg');
        $statementCollection = new Collection([$statementWithImage->id => $statementWithImage]);

        $tenancy = Mockery::mock(Tenancy::class);
        $tenancy->shouldReceive('central')
            ->once()
            ->andReturnUsing(fn ($callback): Collection => $statementCollection);
        app()->instance(Tenancy::class, $tenancy);

        $audit = Mockery::mock(OshaViolationAudit::class);
        $job = makeJobForAudit($audit);

        $violations = new Collection([
            makeViolation(statementId: 1, showReferenceImage: true),
            makeViolation(statementId: 2, showReferenceImage: false),
        ]);

        $result = invokeResolveReferenceImages($job, $violations);

        expect($result)->toBe([1 => 'https://cdn.example.com/ref.jpg']);
    });

    it('maps multiple statement ids to their reference image urls', function (): void {
        $statements = new Collection([
            1 => makeViolationStatement(id: 1, referenceImageUrl: 'https://cdn.example.com/a.jpg'),
            3 => makeViolationStatement(id: 3, referenceImageUrl: 'https://cdn.example.com/b.jpg'),
        ]);

        $tenancy = Mockery::mock(Tenancy::class);
        $tenancy->shouldReceive('central')->andReturnUsing(fn ($callback): Collection => $statements);
        app()->instance(Tenancy::class, $tenancy);

        $audit = Mockery::mock(OshaViolationAudit::class);
        $job = makeJobForAudit($audit);

        $violations = new Collection([
            makeViolation(statementId: 1, showReferenceImage: true),
            makeViolation(statementId: 2, showReferenceImage: false),
            makeViolation(statementId: 3, showReferenceImage: true),
        ]);

        $result = invokeResolveReferenceImages($job, $violations);

        expect($result)->toBe([
            1 => 'https://cdn.example.com/a.jpg',
            3 => 'https://cdn.example.com/b.jpg',
        ]);
    });
});

describe('grade boundaries', function (): void {
    it('returns A at exactly 90%', function (): void {
        // Need exactly 90%: (weight - penalty) / weight = 0.9
        // With weight=10, severity=1: penalty = 10 * 0.1 = 1
        // Score = (10 - 1) / 10 = 90%
        $job = createJobWithViolationsAndStatements([
            ['weight' => 10, 'severity' => 1],
        ]);

        expect(invokeRatingMethod($job))->toBe('A');
    });

    it('returns B at 89.9%', function (): void {
        $job = createJobWithViolationsAndStatements([
            ['weight' => 1000, 'severity' => 1],
            ['weight' => 10, 'severity' => 2],
        ]);

        expect(invokeRatingMethod($job))->toBe('B');
    });

    it('returns B at exactly 80%', function (): void {
        // 80% score: (weight - penalty) / weight = 0.8
        // With weight=10, severity=2: penalty = 10 * 0.2 = 2
        // Score = (10 - 2) / 10 = 80%
        $job = createJobWithViolationsAndStatements([
            ['weight' => 10, 'severity' => 2],
        ]);

        expect(invokeRatingMethod($job))->toBe('B');
    });

    it('returns C at 79.9%', function (): void {
        $job = createJobWithViolationsAndStatements([
            ['weight' => 1000, 'severity' => 2],
            ['weight' => 100, 'severity' => 3],
        ]);

        expect(invokeRatingMethod($job))->toBe('C');
    });

    it('returns C at exactly 70%', function (): void {
        // 70% score: (weight - penalty) / weight = 0.7
        // With weight=10, severity=3: penalty = 10 * 0.3 = 3
        // Score = (10 - 3) / 10 = 70%
        $job = createJobWithViolationsAndStatements([
            ['weight' => 10, 'severity' => 3],
        ]);

        expect(invokeRatingMethod($job))->toBe('C');
    });

    it('returns D at 69.9%', function (): void {
        $job = createJobWithViolationsAndStatements([
            ['weight' => 1000, 'severity' => 3],
            ['weight' => 100, 'severity' => 4],
        ]);

        expect(invokeRatingMethod($job))->toBe('D');
    });

    it('returns D at exactly 60%', function (): void {
        // 60% score: (weight - penalty) / weight = 0.6
        // With weight=10, severity=4: penalty = 10 * 0.4 = 4
        // Score = (10 - 4) / 10 = 60%
        $job = createJobWithViolationsAndStatements([
            ['weight' => 10, 'severity' => 4],
        ]);

        expect(invokeRatingMethod($job))->toBe('D');
    });

    it('returns F at 59.9%', function (): void {
        $job = createJobWithViolationsAndStatements([
            ['weight' => 1000, 'severity' => 4],
            ['weight' => 100, 'severity' => 5],
        ]);

        expect(invokeRatingMethod($job))->toBe('F');
    });
});
