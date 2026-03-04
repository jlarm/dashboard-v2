<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class DeleteTemporaryUploadsCommand extends Command
{
    protected $signature = 'delete:temporary-uploads {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Delete old temporary uploads';

    public function handle(): void
    {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function ($tenant): void {
            $this->info('Start removing old temporary uploads...');

            $temporaryUploadModelClass = config('media-library.temporary_upload_model');

            $temporaryUploads = $temporaryUploadModelClass::old()->get();

            $temporaryUploads->each->delete();

            $this->comment($temporaryUploads->count().' old temporary upload(s) deleted!');
        });
    }
}
