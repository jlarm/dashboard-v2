<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Data\PillarScoreData;
use App\Domain\Tenant\Compliance\Queries\CalculateAuditPillar;
use App\Domain\Tenant\Compliance\Queries\CalculateComplianceScore;
use App\Domain\Tenant\Compliance\Queries\CalculateCyberPillar;
use App\Domain\Tenant\Compliance\Queries\CalculateDocsPillar;
use App\Domain\Tenant\Compliance\Queries\CalculateTrainingPillar;
use App\Domain\Tenant\Compliance\Queries\CalculateVendorPillar;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
use Mockery\MockInterface;

it('renormalizes weights when only audit is applicable', function (): void {
    $store = Store::query()->firstOrFail();

    $this->mock(CalculateAuditPillar::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andReturn(new PillarScoreData(
            key: 'audit', label: 'Audit Health', applicable: true, score: 80.0, weight: 0.0,
        ));
    });
    $this->mock(CalculateTrainingPillar::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andReturn(PillarScoreData::notApplicable('training', 'Training Currency', 'No employees'));
    });
    $this->mock(CalculateDocsPillar::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andReturn(PillarScoreData::notApplicable('docs', 'Document Currency', 'Skipped for test'));
    });

    $score = resolve(CalculateComplianceScore::class)->handle($store, CarbonImmutable::now());

    // Audit alone is applicable → its weight should renormalize to 1.0
    expect($score->score)->toBe(80.0);

    $auditPillar = collect($score->pillars)->firstWhere('key', 'audit');
    expect($auditPillar->weight)->toEqualWithDelta(1.0, 0.0001);
});

it('combines two applicable pillars using their raw weight ratio', function (): void {
    $store = Store::query()->firstOrFail();

    $this->mock(CalculateAuditPillar::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andReturn(new PillarScoreData(
            key: 'audit', label: 'Audit Health', applicable: true, score: 100.0, weight: 0.0,
        ));
    });
    $this->mock(CalculateTrainingPillar::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andReturn(new PillarScoreData(
            key: 'training', label: 'Training Currency', applicable: true, score: 50.0, weight: 0.0,
        ));
    });
    $this->mock(CalculateDocsPillar::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andReturn(PillarScoreData::notApplicable('docs', 'Document Currency', 'Skipped for test'));
    });

    $score = resolve(CalculateComplianceScore::class)->handle($store, CarbonImmutable::now());

    // Cyber + vendor + docs are N/A. Renormalized over 0.60 → audit 7/12, training 5/12.
    // expected: 100 * 7/12 + 50 * 5/12 = 79.166...
    expect($score->score)->toEqualWithDelta(79.2, 0.1);
});

it('uses raw weight ratios across all five applicable pillars', function (): void {
    $store = Store::query()->firstOrFail();

    $this->mock(CalculateAuditPillar::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andReturn(new PillarScoreData(
            key: 'audit', label: 'Audit Health', applicable: true, score: 100.0, weight: 0.0,
        ));
    });
    $this->mock(CalculateTrainingPillar::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andReturn(new PillarScoreData(
            key: 'training', label: 'Training Currency', applicable: true, score: 80.0, weight: 0.0,
        ));
    });
    $this->mock(CalculateCyberPillar::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andReturn(new PillarScoreData(
            key: 'cyber', label: 'Cyber Posture', applicable: true, score: 60.0, weight: 0.0,
        ));
    });
    $this->mock(CalculateVendorPillar::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andReturn(new PillarScoreData(
            key: 'vendor', label: 'Vendor Risk', applicable: true, score: 70.0, weight: 0.0,
        ));
    });
    $this->mock(CalculateDocsPillar::class, function (MockInterface $mock): void {
        $mock->shouldReceive('handle')->andReturn(new PillarScoreData(
            key: 'docs', label: 'Document Currency', applicable: true, score: 90.0, weight: 0.0,
        ));
    });

    $score = resolve(CalculateComplianceScore::class)->handle($store, CarbonImmutable::now());

    // All five applicable; raw weights already sum to 1.00 (0.35 + 0.25 + 0.15 + 0.15 + 0.10).
    // expected: 100*0.35 + 80*0.25 + 60*0.15 + 70*0.15 + 90*0.10 = 83.5
    expect($score->score)->toEqualWithDelta(83.5, 0.1);

    $docs = collect($score->pillars)->firstWhere('key', 'docs');
    expect($docs->weight)->toEqualWithDelta(0.10, 0.0001);
});
