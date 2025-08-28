<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;

class ImportSdsCommand extends Command
{
    public int $chunkSize;
    protected $signature = 'import:sds
        {--file= : Path to JSON file (defaults to database/seeders/data/data.json)}
        {--chunkSize=500 : Number of records per chunk}
        {--skip-duplicates : Skip duplicate records instead of failing}
        {--update-duplicates : Update existing records instead of skipping}
        {--dry-run : Preview import without making changes}';
    protected $description = 'Import SDS data from json file';

    public function handle(): int
    {
        if ($this->option('dry-run')) {
            $this->info('🔎 DRY RUN MODE - No changes will be made');
            $this->newLine();
        }

        try {
            $this->validateFile();
            $data = $this->loadJsonData();

            if ($this->option('dry-run')) {
                return $this->performDryRun($data);
            }

            $this->importData($data);

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }

    private function getFilePath(): string
    {
        return $this->option('file') ?: database_path('seeders/data/sds-data.json');
    }

    private function validateFile(): void
    {
        $filePath = $this->getFilePath();

        if (! file_exists($filePath)) {
            throw new InvalidArgumentException("File not found: {$filePath}");
        }

        if (filesize($filePath) === 0) {
            throw new InvalidArgumentException("File is empty: {$filePath}");
        }

        $this->info("Using file: {$filePath}");
    }

    private function validateRecord(array $record, int $index): array
    {
        $validator = Validator::make($record, [
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'keywords' => 'nullable|array',
            'keywords.*' => 'string',
            'filename' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException("Record {$index}: ".$validator->errors()->first());
        }

        return $validator->validated();
    }

    private function loadJsonData(): array
    {
        $filePath = $this->getFilePath();
        $content = file_get_contents($filePath);

        if ($content === false) {
            throw new InvalidArgumentException("Failed to read file: {$filePath}");
        }

        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Invalid JSON: '.json_last_error_msg());
        }

        if (! is_array($data)) {
            throw new InvalidArgumentException('JSON must contain an array');
        }

        if (isset($data['pdfs']) && is_array($data['pdfs'])) {
            $records = $data['pdfs'];
            $this->info('Extracting '.count($records)." records from 'pdfs' array");

            return $records;
        }

        if ($data !== []) {
            $this->info('Processing '.count($data).' records from root array');

            return $data;
        }

        throw new InvalidArgumentException('No valid data structure found. Expected array or object with "pdfs" key');
    }

    private function importData(array $data): void
    {
        $chunkSize = (int) $this->option('chunkSize');
        $chunks = array_chunk($data, $chunkSize);
        $totalChunks = count($chunks);

        $this->info("Importing {$totalChunks} chunks of {$chunkSize} records each");

        $progressBar = $this->output->createProgressBar($totalChunks);
        $progressBar->start();

        foreach ($chunks as $index => $chunk) {
            $this->processChunk($chunk, $index + 1, $totalChunks);
            $progressBar->advance();
            unset($chunk);
        }

        $progressBar->finish();
        $this->newLine();
    }

    private function processChunk(array $chunk, int $chunkNumber, int $totalChunks): void
    {
        try {
            DB::beginTransaction();

            $chunkSize = (int) $this->option('chunkSize');
            $processData = $this->transformData($chunk, ($chunkNumber - 1) * $chunkSize);

            if ($processData === []) {
                DB::commit();

                return;
            }

            if ($this->option('skip-duplicates') || $this->option('update-duplicates')) {
                $processData = $this->handleDuplicates($processData);
            }

            if ($processData !== []) {
                DB::table('sds')->insert($processData);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->error("Chunk {$chunkNumber}/{$totalChunks} failed: {$e->getMessage()}");
            throw $e;
        }
    }

    private function transformData(array $chunk, int $chunkStartIndex): array
    {
        $now = now();
        $validRecords = [];

        foreach ($chunk as $index => $item) {
            try {
                $validated = $this->validateRecord($item, $chunkStartIndex + $index);
                $validRecords[] = [
                    'uuid' => Str::uuid(),
                    'name' => (string) $validated['name'],
                    'manufacturer' => (string) $validated['manufacturer'],
                    'keywords' => json_encode($validated['keywords'] ?? [], JSON_THROW_ON_ERROR),
                    'file_name' => (string) $validated['filename'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            } catch (InvalidArgumentException $e) {
                $this->warn($e->getMessage());
                Log::warning('SDS import validation failed', [
                    'record_index' => $chunkStartIndex + $index,
                    'error' => $e->getMessage(),
                    'record' => $item,
                ]);
            } catch (Exception $e) {
                $this->error('Transform error at record '.($chunkStartIndex + $index).': '.$e->getMessage());
            }
        }

        return $validRecords;
    }

    private function checkForDuplicates(array $records): array
    {
        $combinations = [];

        foreach ($records as $record) {
            $name = is_string($record['name']) ? $record['name'] : '';
            $manufacturer = is_string($record['manufacturer']) ? $record['manufacturer'] : '';
            $combinations[] = $name.'|'.$manufacturer;
        }

        $names = collect($records)->pluck('name')->filter()->toArray();
        $manufacturers = collect($records)->pluck('manufacturer')->filter()->toArray();

        return DB::table('sds')
            ->whereIn('name', $names)
            ->whereIn('manufacturer', $manufacturers)
            ->get(['name', 'manufacturer'])
            ->map(fn ($record): string => $record->name.'|'.$record->manufacturer)
            ->toArray();
    }

    private function handleDuplicates(array $records): array
    {
        $existingKeys = $this->checkForDuplicates($records);
        $newRecords = [];
        $updatedRecords = [];

        foreach ($records as $record) {
            $key = $record['name'].'|'.$record['manufacturer'];

            if (in_array($key, $existingKeys)) {
                if ($this->option('update-duplicates')) {
                    $updatedRecords[] = $record;
                } else {
                    $this->warn("Skipping duplicate: {$record['name']} - {$record['manufacturer']}");
                }
            } else {
                $newRecords[] = $record;
            }
        }

        if ($this->option('update-duplicates')) {
            $this->updateExistingRecords($updatedRecords);
        }

        return $newRecords;
    }

    private function updateExistingRecords(array $records): void
    {
        foreach ($records as $record) {
            DB::table('sds')
                ->where('name', $record['name'])
                ->where('manufacturer', $record['manufacturer'])
                ->update([
                    'keywords' => $record['keywords'],
                    'file_name' => $record['file_name'],
                    'updated_at' => $record['updated_at'],
                ]);
        }
    }

    private function performDryRun(array $data): int
    {
        $chunkSize = (int) $this->option('chunkSize');
        $chunks = array_chunk($data, $chunkSize);

        $stats = [
            'total_records' => count($data),
            'total_chunks' => count($chunks),
            'valid_records' => 0,
            'invalid_records' => 0,
            'duplicate_records' => 0,
            'would_insert' => 0,
            'would_update' => 0,
        ];

        $this->info("Analyzing {$stats['total_records']} records in {$stats['total_chunks']} chunks");

        foreach ($chunks as $chunkIndex => $chunk) {
            $chunkStats = $this->analyzeChunk($chunk, ($chunkIndex * $chunkSize));

            $stats['valid_records'] += $chunkStats['valid'];
            $stats['invalid_records'] += $chunkStats['invalid'];
            $stats['duplicate_records'] += $chunkStats['duplicates'];
            $stats['would_insert'] += $chunkStats['new'];
            $stats['would_update'] += $chunkStats['updates'];
        }

        $this->displayDryRunResults($stats);

        return Command::SUCCESS;
    }

    private function analyzeChunk(array $chunk, int $chunkStartIndex): array
    {
        $stats = ['valid' => 0, 'invalid' => 0, 'duplicates' => 0, 'new' => 0, 'updates' => 0];

        foreach ($chunk as $index => $item) {
            try {
                $this->validateRecord($item, $chunkStartIndex + $index);
                $stats['valid']++;

                $name = is_string($item['name']) ? $item['name'] : '';
                $manufacturer = is_string($item['manufacturer']) ? $item['manufacturer'] : '';

                $exists = DB::table('sds')
                    ->where('name', $name)
                    ->where('manufacturer', $manufacturer)
                    ->exists();

                if ($exists) {
                    $stats['duplicates']++;
                    if ($this->option('update-duplicates')) {
                        $stats['updates']++;
                    }
                } else {
                    $stats['new']++;
                }
            } catch (InvalidArgumentException $e) {
                $this->warn('Validation error at record '.($chunkStartIndex + $index).': '.$e->getMessage());
                $stats['invalid']++;
            } catch (Exception $e) {
                $this->error('Unexpected error at record '.($chunkStartIndex + $index).': '.$e->getMessage());
                $stats['invalid']++;
            }
        }

        return $stats;
    }

    private function displayDryRunResults(array $stats): void
    {
        $this->newLine();
        $this->info('📊 Dry Run Results');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Records', $stats['total_records']],
                ['Valid Records', $stats['valid_records']],
                ['Invalid Records', $stats['invalid_records']],
                ['Duplicate Records', $stats['duplicate_records']],
                ['Would Insert', $stats['would_insert']],
                ['Would Update', $stats['would_update']],
            ]
        );

        if ($stats['invalid_records'] > 0) {
            $this->warn("⚠️ {$stats['invalid_records']} records have validation errors");
        }

        if ($stats['duplicate_records'] > 0) {
            $duplicate_action = $this->option('update-duplicates') ? 'updated' : 'skipped';
            $this->info("🔄 {$stats['duplicate_records']} duplicates would be {$duplicate_action}");
        }

        $this->newLine();
        $this->info('💡 Add --no-dry-run to perform actual import');
    }
}
