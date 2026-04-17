<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Override;

class RepairViolationStatementKeywordsCommand extends Command
{
    #[Override]
    protected $signature = 'violation-statements:repair-keywords
                            {--dry-run : Preview affected rows without writing to the database}';

    #[Override]
    protected $description = 'Fix double-encoded keywords JSON in violation_statements and the three legacy tables.';

    /** @var list<string> */
    protected array $tables = [
        'violation_statements',
        'osha_violation_statements',
        'glba_violation_statements',
        'body_shop_violation_statements',
    ];

    public function handle(): int
    {
        $isDryRun = (bool) $this->option('dry-run');

        if ($isDryRun) {
            $this->warn('DRY RUN — no data will be written.');
        }

        foreach ($this->tables as $table) {
            $affected = DB::table($table)
                ->whereRaw("JSON_TYPE(keywords) = 'STRING'")
                ->count();

            if ($affected === 0) {
                $this->info("[{$table}] No double-encoded rows found.");

                continue;
            }

            $this->warn("[{$table}] Found {$affected} double-encoded row(s).");

            if (! $isDryRun) {
                DB::table($table)
                    ->whereRaw("JSON_TYPE(keywords) = 'STRING'")
                    ->update(['keywords' => DB::raw('JSON_UNQUOTE(keywords)')]);

                $this->info("[{$table}] Fixed {$affected} row(s).");
            }
        }

        if ($isDryRun) {
            $this->newLine();
            $this->info('Dry run complete. Run without --dry-run to apply fixes.');
        }

        return self::SUCCESS;
    }
}
