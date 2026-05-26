<?php

declare(strict_types=1);

use App\Models\Sds;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

uses(TestCase::class, LazilyRefreshDatabase::class);

beforeEach(function (): void {
    DB::table('sds')->truncate();

    $this->jsonPath = tempnam(sys_get_temp_dir(), 'sds-import-').'.json';
});

afterEach(function (): void {
    if (isset($this->jsonPath) && file_exists($this->jsonPath)) {
        unlink($this->jsonPath);
    }
});

/**
 * @param  array<int, array<string, mixed>>|array<string, mixed>  $payload
 */
function writeImportFile(string $path, array $payload): void
{
    file_put_contents($path, json_encode($payload, JSON_THROW_ON_ERROR));
}

it('imports records from a root JSON array', function (): void {
    $records = [
        ['name' => 'Acetone', 'manufacturer' => 'ChemCo', 'keywords' => ['solvent'], 'filename' => 'acetone.pdf'],
        ['name' => 'Benzene', 'manufacturer' => 'ChemCo', 'keywords' => ['aromatic'], 'filename' => 'benzene.pdf'],
    ];
    writeImportFile($this->jsonPath, $records);

    $exitCode = Artisan::call('import:sds', ['--file' => $this->jsonPath]);

    expect($exitCode)->toBe(0);
    expect(Sds::query()->count())->toBe(count($records));

    foreach ($records as $record) {
        $row = Sds::query()
            ->where('name', $record['name'])
            ->where('manufacturer', $record['manufacturer'])
            ->first();

        expect($row)->not->toBeNull()
            ->and($row->file_name)->toBe($record['filename'])
            ->and($row->keywords)->toBe($record['keywords'])
            ->and($row->uuid)->toBeString()->not->toBeEmpty();
    }
});

it('imports records from a JSON object with a pdfs key', function (): void {
    $records = [
        ['name' => 'Toluene', 'manufacturer' => 'OtherCo', 'keywords' => ['solvent'], 'filename' => 'toluene.pdf'],
    ];
    writeImportFile($this->jsonPath, ['pdfs' => $records]);

    Artisan::call('import:sds', ['--file' => $this->jsonPath]);

    expect(Sds::query()->where('name', 'Toluene')->where('manufacturer', 'OtherCo')->exists())->toBeTrue();
});

it('skips duplicate records when --skip-duplicates is set', function (): void {
    Sds::factory()->create(['name' => 'Acetone', 'manufacturer' => 'ChemCo', 'file_name' => 'original.pdf']);

    writeImportFile($this->jsonPath, [
        ['name' => 'Acetone', 'manufacturer' => 'ChemCo', 'keywords' => ['solvent'], 'filename' => 'new.pdf'],
        ['name' => 'Methanol', 'manufacturer' => 'ChemCo', 'keywords' => ['alcohol'], 'filename' => 'methanol.pdf'],
    ]);

    Artisan::call('import:sds', ['--file' => $this->jsonPath, '--skip-duplicates' => true]);

    expect(Sds::query()->count())->toBe(2);

    $acetone = Sds::query()->where('name', 'Acetone')->first();
    expect($acetone->file_name)->toBe('original.pdf');

    expect(Sds::query()->where('name', 'Methanol')->exists())->toBeTrue();
});

it('updates duplicate records when --update-duplicates is set', function (): void {
    $original = Sds::factory()->create([
        'name' => 'Acetone',
        'manufacturer' => 'ChemCo',
        'file_name' => 'old.pdf',
        'keywords' => ['old-keyword'],
    ]);

    writeImportFile($this->jsonPath, [
        ['name' => 'Acetone', 'manufacturer' => 'ChemCo', 'keywords' => ['fresh-keyword'], 'filename' => 'fresh.pdf'],
    ]);

    Artisan::call('import:sds', ['--file' => $this->jsonPath, '--update-duplicates' => true]);

    $updated = Sds::query()->where('id', $original->id)->first();
    expect($updated->file_name)->toBe('fresh.pdf');
    expect($updated->keywords)->toBe(['fresh-keyword']);
    expect(Sds::query()->count())->toBe(1);
});

it('does not write to the database in --dry-run mode', function (): void {
    $records = [
        ['name' => 'Acetone', 'manufacturer' => 'ChemCo', 'keywords' => [], 'filename' => 'acetone.pdf'],
        ['name' => 'Benzene', 'manufacturer' => 'ChemCo', 'keywords' => [], 'filename' => 'benzene.pdf'],
    ];
    writeImportFile($this->jsonPath, $records);

    Artisan::call('import:sds', ['--file' => $this->jsonPath, '--dry-run' => true]);

    expect(Sds::query()->count())->toBe(0);

    $output = Artisan::output();
    expect($output)->toContain('DRY RUN')
        ->and($output)->toContain((string) count($records));
});

it('reports a failure when the file does not exist', function (): void {
    $missing = sys_get_temp_dir().'/sds-missing-'.uniqid().'.json';

    $exitCode = Artisan::call('import:sds', ['--file' => $missing]);

    expect($exitCode)->toBe(1)
        ->and(Sds::query()->count())->toBe(0);
});

it('rejects records missing required fields', function (): void {
    $valid = ['name' => 'Acetone', 'manufacturer' => 'ChemCo', 'keywords' => [], 'filename' => 'acetone.pdf'];
    $invalid = ['manufacturer' => 'NoNameCo', 'filename' => 'noname.pdf'];

    writeImportFile($this->jsonPath, [$valid, $invalid]);

    Artisan::call('import:sds', ['--file' => $this->jsonPath]);

    expect(Sds::query()->count())->toBe(1);
    expect(Sds::query()->where('name', 'Acetone')->exists())->toBeTrue();
});
