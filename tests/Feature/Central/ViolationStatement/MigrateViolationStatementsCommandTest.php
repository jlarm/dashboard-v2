<?php

declare(strict_types=1);

use App\Enums\ViolationStatementCategory;
use App\Models\BodyShopViolationStatement;
use App\Models\GlbaViolationStatements;
use App\Models\OshaViolationStatements;
use App\Models\ViolationStatement;
use Illuminate\Support\Facades\DB;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('violation_statements')->truncate();
    DB::table('osha_violation_statements')->truncate();
    DB::table('glba_violation_statements')->truncate();
    DB::table('body_shop_violation_statements')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
});

it('migrates rows from each legacy table into violation_statements with the matching category', function (): void {
    $osha = OshaViolationStatements::query()->create([
        'statement' => 'OSHA: keep aisles clear',
        'keywords' => ['aisles', 'osha'],
        'weight' => 5,
    ]);
    $body = BodyShopViolationStatement::query()->create([
        'statement' => 'BodyShop: secure paint guns',
        'keywords' => ['paint'],
        'weight' => 7,
    ]);
    $glba = GlbaViolationStatements::query()->create([
        'statement' => 'GLBA: shred customer documents',
        'keywords' => ['shred'],
        'weight' => 9,
    ]);

    $this->artisan('violation-statements:migrate')->assertSuccessful();

    expect(ViolationStatement::query()->count())->toBe(3);

    $categoryValues = fn (ViolationStatement $row): array => $row->categories
        ->map(fn (ViolationStatementCategory $c): string => $c->value)
        ->all();

    $oshaRow = ViolationStatement::query()->where('statement', $osha->statement)->sole();
    expect($categoryValues($oshaRow))->toBe([ViolationStatementCategory::Osha->value])
        ->and($oshaRow->keywords)->toBe($osha->keywords)
        ->and($oshaRow->weight)->toBe($osha->weight);

    $bodyRow = ViolationStatement::query()->where('statement', $body->statement)->sole();
    expect($categoryValues($bodyRow))->toBe([ViolationStatementCategory::BodyShop->value])
        ->and($bodyRow->keywords)->toBe($body->keywords)
        ->and($bodyRow->weight)->toBe($body->weight);

    $glbaRow = ViolationStatement::query()->where('statement', $glba->statement)->sole();
    expect($categoryValues($glbaRow))->toBe([ViolationStatementCategory::Glba->value])
        ->and($glbaRow->keywords)->toBe($glba->keywords)
        ->and($glbaRow->weight)->toBe($glba->weight);
});

it('merges statements that appear in multiple legacy tables into one row with combined categories', function (): void {
    $shared = 'Shared violation across sources';

    OshaViolationStatements::query()->create(['statement' => $shared, 'keywords' => ['o'], 'weight' => 3]);
    BodyShopViolationStatement::query()->create(['statement' => $shared, 'keywords' => ['b'], 'weight' => 3]);
    GlbaViolationStatements::query()->create(['statement' => $shared, 'keywords' => ['g'], 'weight' => 3]);

    $this->artisan('violation-statements:migrate')->assertSuccessful();

    $row = ViolationStatement::query()->where('statement', $shared)->sole();

    expect(ViolationStatement::query()->count())->toBe(1);
    expect($row->categories->map(fn (ViolationStatementCategory $c): string => $c->value)->all())
        ->toEqualCanonicalizing([
            ViolationStatementCategory::Osha->value,
            ViolationStatementCategory::BodyShop->value,
            ViolationStatementCategory::Glba->value,
        ]);
});

it('treats whitespace and case differences as the same statement when merging', function (): void {
    OshaViolationStatements::query()->create(['statement' => 'Wear PPE at all times', 'keywords' => [], 'weight' => 1]);
    BodyShopViolationStatement::query()->create(['statement' => '  wear ppe at all times  ', 'keywords' => [], 'weight' => 1]);

    $this->artisan('violation-statements:migrate')->assertSuccessful();

    expect(ViolationStatement::query()->count())->toBe(1);

    $row = ViolationStatement::query()->first();
    expect($row->categories->map(fn (ViolationStatementCategory $c): string => $c->value)->all())
        ->toEqualCanonicalizing([
            ViolationStatementCategory::Osha->value,
            ViolationStatementCategory::BodyShop->value,
        ]);
});

it('skips statements that already exist in violation_statements', function (): void {
    $existing = ViolationStatement::factory()->create([
        'statement' => 'Existing statement',
        'categories' => [ViolationStatementCategory::Osha->value],
    ]);
    OshaViolationStatements::query()->create([
        'statement' => 'EXISTING STATEMENT',
        'keywords' => ['new'],
        'weight' => 99,
    ]);

    $this->artisan('violation-statements:migrate')
        ->expectsOutputToContain('SKIP (already exists)')
        ->assertSuccessful();

    expect(ViolationStatement::query()->count())->toBe(1);

    $row = ViolationStatement::query()->find($existing->id);
    expect($row->categories->map(fn (ViolationStatementCategory $c): string => $c->value)->all())
        ->toBe([ViolationStatementCategory::Osha->value])
        ->and($row->weight)->toBe($existing->weight);
});

it('writes nothing in --dry-run mode', function (): void {
    OshaViolationStatements::query()->create(['statement' => 'Dry run only', 'keywords' => [], 'weight' => 1]);

    $this->artisan('violation-statements:migrate', ['--dry-run' => true])
        ->expectsOutputToContain('DRY RUN')
        ->assertSuccessful();

    expect(ViolationStatement::query()->count())->toBe(0);
});
