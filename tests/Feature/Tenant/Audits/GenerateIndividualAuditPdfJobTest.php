<?php

declare(strict_types=1);

use App\Jobs\GenerateIndividualAuditPdfJob;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();

    // Job's constructor accesses $audit->manager?->name without preloading.
    // Production allows lazy loading; mirror that here so the test exercises
    // the same aggregation path.
    Illuminate\Database\Eloquent\Model::preventLazyLoading(false);
});

afterEach(function (): void {
    Illuminate\Database\Eloquent\Model::preventLazyLoading(true);
});

it('aggregates failing-answer counts per manager across the parent and its children', function (): void {
    $manager = User::query()->create([
        'name' => 'Mary Manager',
        'email' => 'mary-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);

    $parent = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'manager_id' => $manager->id,
        'audit_date' => now()->subDays(3)->toDateString(),
        'deal_jacket_date' => now()->subDays(3)->toDateString(),
        'individual_q3_answer' => 2, // counts
        'individual_q4_answer' => 1, // does not count
    ]);

    IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'manager_id' => $manager->id,
        'parent_id' => $parent->id,
        'audit_date' => now()->subDays(2)->toDateString(),
        'deal_jacket_date' => now()->subDays(2)->toDateString(),
        'individual_q5_answer' => 2, // counts
        'individual_q6_answer' => 2, // counts
    ]);

    $job = new GenerateIndividualAuditPdfJob($parent);

    expect($job->issueCountByManager->get($manager->name))->toBe(3);
});

it('skips excluded question keys (q1) and q2 from the issue counts', function (): void {
    $manager = User::query()->create([
        'name' => 'Excluded Test',
        'email' => 'excluded-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);

    $parent = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'manager_id' => $manager->id,
        'audit_date' => now()->toDateString(),
        'deal_jacket_date' => now()->toDateString(),
        'individual_q1_answer' => 2, // excluded
        'individual_q2_answer' => 2, // excluded
        'individual_q3_answer' => 2, // counts
    ]);

    $job = new GenerateIndividualAuditPdfJob($parent);

    expect($job->issueCountByManager->get($manager->name))->toBe(1);
});

it('builds a per-question manager tally with a Total column at the end', function (): void {
    $alice = User::query()->create([
        'name' => 'Alice',
        'email' => 'alice-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $bob = User::query()->create([
        'name' => 'Bob',
        'email' => 'bob-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);

    $parent = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'manager_id' => $alice->id,
        'audit_date' => now()->subDay()->toDateString(),
        'deal_jacket_date' => now()->subDay()->toDateString(),
        'individual_q3_answer' => 2,
    ]);

    IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'manager_id' => $bob->id,
        'parent_id' => $parent->id,
        'audit_date' => now()->subDay()->toDateString(),
        'deal_jacket_date' => now()->subDay()->toDateString(),
        'individual_q3_answer' => 2,
    ]);

    $job = new GenerateIndividualAuditPdfJob($parent);

    expect($job->results)->toHaveKey('individual_q3_answer');
    expect($job->results['individual_q3_answer']['Total'])->toBe(2);
    expect(array_key_last($job->results['individual_q3_answer']))->toBe('Total');
    expect($job->results['individual_q3_answer'][$alice->name])->toBe(1);
    expect($job->results['individual_q3_answer'][$bob->name])->toBe(1);
});

it('accumulates the grand total of failing answers across all managers', function (): void {
    $manager = User::query()->create([
        'name' => 'Solo',
        'email' => 'solo-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);

    $parent = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'manager_id' => $manager->id,
        'audit_date' => now()->toDateString(),
        'deal_jacket_date' => now()->toDateString(),
        'individual_q3_answer' => 2,
        'individual_q4_answer' => 2,
    ]);

    $job = new GenerateIndividualAuditPdfJob($parent);

    expect($job->grandTotal)->toBe(2);
    expect($job->totals[$manager->name])->toBe(2);
});
