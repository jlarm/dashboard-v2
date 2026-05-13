<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\GetLocationGrades;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->user = User::query()->create([
        'name' => 'Audit Author '.uniqid(),
        'email' => 'audit-author-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
});

it('returns an empty list when no store ids are scoped', function (): void {
    expect(resolve(GetLocationGrades::class)->handleForStores([]))->toBe([]);
});

it('returns one row per store ordered by name with their latest grades', function (): void {
    $storeA = Store::query()->firstOrFail();
    $storeA->update(['name' => 'Alpha Motors']);

    $storeB = Store::query()->create(['name' => 'Beta Auto', 'slug' => 'beta-auto-'.uniqid()]);

    seedOshaGrade($storeA, 'A');
    seedGlbaGrade($storeA, 'B');
    seedBodyShopGrade($storeA, 'A');
    seedDealJacketRating($storeA, 92.0);

    seedOshaGrade($storeB, 'C');

    $rows = resolve(GetLocationGrades::class)->handleForStores([$storeB->id, $storeA->id]);

    expect($rows)->toHaveCount(2);
    expect($rows[0]->store_name)->toBe('Alpha Motors');
    expect($rows[0]->osha)->toBe('A');
    expect($rows[0]->glba)->toBe('B');
    expect($rows[0]->body_shop)->toBe('A');
    expect($rows[0]->deal_jacket)->toBe('A');
    expect($rows[0]->overall)->toBe('A');

    expect($rows[1]->store_name)->toBe('Beta Auto');
    expect($rows[1]->osha)->toBe('C');
    expect($rows[1]->glba)->toBeNull();
    expect($rows[1]->body_shop)->toBeNull();
    expect($rows[1]->deal_jacket)->toBeNull();
    expect($rows[1]->overall)->toBe('C');
});

it('uses the most recent audit when multiple exist', function (): void {
    $store = Store::query()->firstOrFail();

    seedOshaGrade($store, 'C', now()->subYear());
    seedOshaGrade($store, 'A', now()->subWeek());

    $rows = resolve(GetLocationGrades::class)->handleForStores([$store->id]);

    expect($rows[0]->osha)->toBe('A');
});

it('skips N/A and empty grades when picking the latest', function (): void {
    $store = Store::query()->firstOrFail();

    seedOshaGrade($store, 'B', now()->subMonth());
    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->user->id,
        'store_id' => $store->id,
        'date' => now()->subDay()->toDateString(),
        'grade' => 'N/A',
    ]);

    $rows = resolve(GetLocationGrades::class)->handleForStores([$store->id]);

    expect($rows[0]->osha)->toBe('B');
});

it('maps deal jacket ratings to letter grades', function (): void {
    $store = Store::query()->firstOrFail();

    seedDealJacketRating($store, 75.0);

    $rows = resolve(GetLocationGrades::class)->handleForStores([$store->id]);

    expect($rows[0]->deal_jacket)->toBe('C');
    expect($rows[0]->overall)->toBe('C');
});

function seedOshaGrade(Store $store, string $grade, ?Carbon\CarbonInterface $date = null): void
{
    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => test()->user->id,
        'store_id' => $store->id,
        'date' => ($date ?? now())->toDateString(),
        'grade' => $grade,
    ]);
}

function seedGlbaGrade(Store $store, string $grade, ?Carbon\CarbonInterface $date = null): void
{
    GlbaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => test()->user->id,
        'store_id' => $store->id,
        'date' => ($date ?? now())->toDateString(),
        'grade' => $grade,
    ]);
}

function seedBodyShopGrade(Store $store, string $grade, ?Carbon\CarbonInterface $date = null): void
{
    BodyShopViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => test()->user->id,
        'store_id' => $store->id,
        'date' => ($date ?? now())->toDateString(),
        'grade' => $grade,
    ]);
}

function seedDealJacketRating(Store $store, float $rating, ?Carbon\CarbonInterface $date = null): void
{
    IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => test()->user->id,
        'store_id' => $store->id,
        'audit_date' => ($date ?? now())->toDateString(),
        'rating' => $rating,
    ]);
}
