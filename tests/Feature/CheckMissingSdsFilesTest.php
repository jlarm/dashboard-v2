<?php

declare(strict_types=1);

use App\Models\Sds;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

uses(TestCase::class, LazilyRefreshDatabase::class);

beforeEach(function (): void {
    DB::table('sds')->truncate();
    Storage::fake('sds-sheets');

    $this->logFile = 'check-missing-'.uniqid().'.txt';
});

afterEach(function (): void {
    if (isset($this->logFile)) {
        $path = storage_path('logs/'.$this->logFile);
        if (file_exists($path)) {
            unlink($path);
        }
    }
});

it('reports success when every SDS record has its file present', function (): void {
    $records = Sds::factory()->count(3)->create();

    foreach ($records as $record) {
        Storage::disk('sds-sheets')->put($record->file_name, 'pdf-bytes');
    }

    Artisan::call('sds:check-missing-files', ['--output' => $this->logFile]);

    $output = Artisan::output();
    expect($output)->toContain('All SDS files are present');
    expect(file_exists(storage_path('logs/'.$this->logFile)))->toBeFalse();
});

it('writes missing file names to the output log', function (): void {
    $present = Sds::factory()->create();
    $missingOne = Sds::factory()->create();
    $missingTwo = Sds::factory()->create();

    Storage::disk('sds-sheets')->put($present->file_name, 'pdf-bytes');

    Artisan::call('sds:check-missing-files', ['--output' => $this->logFile]);

    $logPath = storage_path('logs/'.$this->logFile);
    expect(file_exists($logPath))->toBeTrue();

    $logContent = (string) file_get_contents($logPath);
    expect($logContent)
        ->toContain($missingOne->file_name)
        ->toContain($missingTwo->file_name)
        ->not->toContain($present->file_name);

    $output = Artisan::output();
    expect($output)->toContain('Found 2 missing files');
});

it('ignores records that have no file name', function (): void {
    Sds::factory()->create(['file_name' => '']);
    $missing = Sds::factory()->create();

    Artisan::call('sds:check-missing-files', ['--output' => $this->logFile]);

    $logPath = storage_path('logs/'.$this->logFile);
    expect(file_exists($logPath))->toBeTrue();

    $logContent = (string) file_get_contents($logPath);
    expect(mb_substr_count($logContent, $missing->file_name))->toBe(1);

    $output = Artisan::output();
    expect($output)->toContain('Found 1 missing files');
});

it('honors a custom --output filename', function (): void {
    Sds::factory()->create();

    $customName = 'custom-missing-'.uniqid().'.txt';

    try {
        Artisan::call('sds:check-missing-files', ['--output' => $customName]);

        expect(file_exists(storage_path('logs/'.$customName)))->toBeTrue();
    } finally {
        $path = storage_path('logs/'.$customName);
        if (file_exists($path)) {
            unlink($path);
        }
    }
});
