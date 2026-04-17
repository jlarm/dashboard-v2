<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Sds;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Override;

class CheckMissingSdsFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    #[Override]
    protected $signature = 'sds:check-missing-files {--output=missing_sds_files.txt : Output file name}';

    /**
     * The console command description.
     *
     * @var string
     */
    #[Override]
    protected $description = 'Check for missing SDS files in storage and log them to a text file';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $outputFile = $this->option('output');
        $missingFiles = [];

        $this->info('Checking SDS files...');

        $progressBar = $this->output->createProgressBar(Sds::query()->count());
        $progressBar->start();

        Sds::query()->chunk(100, function ($sdsRecord) use (&$missingFiles, &$progressBar): void {
            foreach ($sdsRecord as $sds) {
                if ($sds->file_name && ! Storage::disk('sds-sheets')->exists($sds->file_name)) {
                    $missingFiles[] = $sds->file_name;
                }

                $progressBar->advance();
            }
        });

        $progressBar->finish();
        $this->newLine();

        if ($missingFiles === []) {
            $this->info('All SDS files are present in storage');

            return;
        }

        $content = implode(PHP_EOL, $missingFiles);
        file_put_contents(storage_path("logs/{$outputFile}"), $content);

        $this->comment('Found '.count($missingFiles).' missing files.');
        $this->comment('Missing files logged to: '.storage_path("logs/{$outputFile}"));
    }
}
