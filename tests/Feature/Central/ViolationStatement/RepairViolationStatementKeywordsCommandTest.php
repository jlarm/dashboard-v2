<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('violation_statements')->truncate();
    DB::table('osha_violation_statements')->truncate();
    DB::table('glba_violation_statements')->truncate();
    DB::table('body_shop_violation_statements')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
});

/**
 * Insert a row whose `keywords` column is double-encoded JSON
 * (a JSON string whose value is itself a JSON-encoded array).
 *
 * @param  array<int, string>  $keywords
 */
function insertDoubleEncoded(string $table, string $statement, array $keywords, int $weight = 1): int
{
    $payload = [
        'statement' => $statement,
        'keywords' => json_encode(json_encode($keywords)),
        'weight' => $weight,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    if ($table === 'violation_statements') {
        $payload['categories'] = json_encode([]);
    }

    return (int) DB::table($table)->insertGetId($payload);
}

/**
 * Insert a row whose `keywords` column is correctly encoded as a JSON array.
 *
 * @param  array<int, string>  $keywords
 */
function insertNormallyEncoded(string $table, string $statement, array $keywords, int $weight = 1): int
{
    $payload = [
        'statement' => $statement,
        'keywords' => json_encode($keywords),
        'weight' => $weight,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    if ($table === 'violation_statements') {
        $payload['categories'] = json_encode([]);
    }

    return (int) DB::table($table)->insertGetId($payload);
}

/**
 * @return array<int, string>
 */
function decodedKeywords(string $table, int $id): array
{
    /** @var object{keywords: string|null} $row */
    $row = DB::table($table)->where('id', $id)->first(['keywords']);

    /** @var array<int, string> $decoded */
    $decoded = json_decode((string) $row->keywords, true);

    return $decoded;
}

it('repairs double-encoded keywords in violation_statements', function (): void {
    $keywords = ['alpha', 'beta', 'gamma'];
    $id = insertDoubleEncoded('violation_statements', 'Needs repair', $keywords);

    $this->artisan('violation-statements:repair-keywords')->assertSuccessful();

    expect(decodedKeywords('violation_statements', $id))->toBe($keywords);
});

it('repairs double-encoded keywords across every legacy table', function (): void {
    $expected = [
        'osha_violation_statements' => ['osha-a', 'osha-b'],
        'glba_violation_statements' => ['glba-a'],
        'body_shop_violation_statements' => ['bs-a', 'bs-b', 'bs-c'],
    ];

    $ids = [];
    foreach ($expected as $table => $keywords) {
        $ids[$table] = insertDoubleEncoded($table, "Broken row in {$table}", $keywords);
    }

    $this->artisan('violation-statements:repair-keywords')->assertSuccessful();

    foreach ($expected as $table => $keywords) {
        expect(decodedKeywords($table, $ids[$table]))->toBe($keywords);
    }
});

it('leaves correctly-encoded rows unchanged', function (): void {
    $keywords = ['fine', 'as-is'];
    $id = insertNormallyEncoded('violation_statements', 'Already correct', $keywords);

    $this->artisan('violation-statements:repair-keywords')
        ->expectsOutputToContain('No double-encoded rows found')
        ->assertSuccessful();

    expect(decodedKeywords('violation_statements', $id))->toBe($keywords);
});

it('reports affected counts without writing when --dry-run is passed', function (): void {
    $keywords = ['x', 'y'];
    $id = insertDoubleEncoded('violation_statements', 'Dry-run subject', $keywords);

    $this->artisan('violation-statements:repair-keywords', ['--dry-run' => true])
        ->expectsOutputToContain('DRY RUN')
        ->expectsOutputToContain('Found 1 double-encoded row')
        ->assertSuccessful();

    /** @var object{keywords: string|null} $row */
    $row = DB::table('violation_statements')->where('id', $id)->first(['keywords']);

    // Still double-encoded — the outer json_decode produces a string, not an array.
    $outer = json_decode((string) $row->keywords, true);
    expect($outer)->toBeString();
    expect(json_decode((string) $outer, true))->toBe($keywords);
});
