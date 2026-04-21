<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\SharedDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Override;
use Throwable;

class MigrateSharedDocumentsToCentralDocsCommand extends Command
{
    private const string SOURCE_DISK = 'public';
    private const string TARGET_DISK = 'central-docs';

    #[Override]
    protected $signature = 'shared-documents:migrate-to-central-docs
        {--dry-run : Preview without copying any files}
        {--delete-source : Delete the source file after a verified copy}';

    #[Override]
    protected $description = 'Copy shared_documents file_name entries from the local public disk to the central-docs DO Spaces bucket';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $deleteSource = (bool) $this->option('delete-source');

        $documents = SharedDocument::query()
            ->whereNotNull('file_name')
            ->where('file_name', '!=', '')
            ->orderBy('id')
            ->get(['id', 'title', 'file_name']);

        if ($documents->isEmpty()) {
            $this->info('No shared documents with file attachments found.');

            return self::SUCCESS;
        }

        $source = Storage::disk(self::SOURCE_DISK);
        $target = Storage::disk(self::TARGET_DISK);

        $copied = 0;
        $skippedAlreadyPresent = 0;
        $skippedMissingSource = 0;
        $failed = 0;
        $deleted = 0;

        $this->line(sprintf('Processing %d shared documents…', $documents->count()));

        $bar = $this->output->createProgressBar($documents->count());
        $bar->start();

        foreach ($documents as $document) {
            $path = (string) $document->file_name;
            $bar->advance();

            if (! $source->exists($path)) {
                $skippedMissingSource++;
                $this->warn(" [{$document->id}] source missing: {$path}");

                continue;
            }

            if ($target->exists($path)) {
                $skippedAlreadyPresent++;

                if ($deleteSource && ! $dryRun) {
                    $source->delete($path);
                    $deleted++;
                }

                continue;
            }

            if ($dryRun) {
                $copied++;

                continue;
            }

            try {
                $stream = $source->readStream($path);

                if ($stream === null) {
                    $failed++;
                    $this->warn(" [{$document->id}] unable to open stream: {$path}");

                    continue;
                }

                $target->writeStream($path, $stream);

                if (is_resource($stream)) {
                    fclose($stream);
                }

                $sourceSize = $source->size($path);
                $targetSize = $target->size($path);

                if ($sourceSize !== $targetSize) {
                    $failed++;
                    $this->warn(" [{$document->id}] size mismatch for {$path}: source={$sourceSize}, target={$targetSize}");

                    continue;
                }

                $copied++;

                if ($deleteSource) {
                    $source->delete($path);
                    $deleted++;
                }
            } catch (Throwable $error) {
                $failed++;
                $this->warn(" [{$document->id}] copy failed for {$path}: {$error->getMessage()}");
            }
        }

        $bar->finish();
        $this->newLine(2);

        $prefix = $dryRun ? '[dry-run] ' : '';
        $this->info(sprintf(
            '%sDone. copied=%d, skipped_already_present=%d, skipped_missing_source=%d, failed=%d, deleted_source=%d',
            $prefix,
            $copied,
            $skippedAlreadyPresent,
            $skippedMissingSource,
            $failed,
            $deleted,
        ));

        return $failed === 0 ? self::SUCCESS : self::FAILURE;
    }
}
