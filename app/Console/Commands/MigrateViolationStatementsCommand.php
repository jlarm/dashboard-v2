<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\ViolationStatementCategory;
use App\Models\BodyShopViolationStatement;
use App\Models\GlbaViolationStatements;
use App\Models\OshaViolationStatements;
use App\Models\ViolationStatement;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Override;

class MigrateViolationStatementsCommand extends Command
{
    #[Override]
    protected $signature = 'violation-statements:migrate
                            {--dry-run : Preview what will be inserted without writing to the database}';

    #[Override]
    protected $description = 'Copy body_shop, glba, and osha violation statements into violation_statements, merging duplicates by statement text.';

    public function handle(): void
    {
        $isDryRun = (bool) $this->option('dry-run');

        if ($isDryRun) {
            $this->warn('DRY RUN — no data will be written.');
        }

        /** @var Collection<string, array{statement: string, keywords: array<int, string>|null, weight: int, categories: list<string>}> $merged */
        $merged = collect();

        $sources = [
            [ViolationStatementCategory::BodyShop, BodyShopViolationStatement::query()->get()],
            [ViolationStatementCategory::Glba, GlbaViolationStatements::query()->get()],
            [ViolationStatementCategory::Osha, OshaViolationStatements::query()->get()],
        ];

        foreach ($sources as [$category, $rows]) {
            $this->info("Reading {$rows->count()} rows from {$category->value} source...");

            foreach ($rows as $row) {
                $key = $this->normalizeStatement($row->statement);

                if ($merged->has($key)) {
                    // Merge category into existing entry.
                    $existing = $merged->get($key);
                    if (! in_array($category->value, $existing['categories'], strict: true)) {
                        $existing['categories'][] = $category->value;
                        $merged->put($key, $existing);
                    }
                } else {
                    $merged->put($key, [
                        'statement' => $row->statement,
                        'keywords' => $row->keywords,
                        'weight' => $row->weight,
                        'categories' => [$category->value],
                    ]);
                }
            }
        }

        $duplicates = $merged->filter(fn (array $entry): bool => count($entry['categories']) > 1);

        $this->info("Total unique statements: {$merged->count()}");
        $this->info("Statements spanning multiple categories: {$duplicates->count()}");

        if ($duplicates->isNotEmpty()) {
            $this->newLine();
            $this->warn('Multi-category statements:');
            foreach ($duplicates as $entry) {
                $categories = implode(', ', $entry['categories']);
                $this->line("  [{$categories}] {$entry['statement']}");
            }
            $this->newLine();
        }

        if ($isDryRun) {
            $this->info('Dry run complete. Pass without --dry-run to write records.');

            return;
        }

        $inserted = 0;
        $skipped = 0;

        foreach ($merged as $entry) {
            $alreadyExists = ViolationStatement::query()
                ->whereRaw('LOWER(TRIM(statement)) = ?', [mb_strtolower(mb_trim($entry['statement']))])
                ->exists();

            if ($alreadyExists) {
                $skipped++;
                $this->comment("SKIP (already exists): {$entry['statement']}");

                continue;
            }

            ViolationStatement::query()->create([
                'statement' => $entry['statement'],
                'keywords' => $entry['keywords'],
                'weight' => $entry['weight'],
                'categories' => $entry['categories'],
            ]);

            $inserted++;
        }

        $this->newLine();
        $this->info("Done. Inserted: {$inserted} | Skipped (already exist): {$skipped}");
    }

    private function normalizeStatement(string $statement): string
    {
        return mb_strtolower(mb_trim($statement));
    }
}
