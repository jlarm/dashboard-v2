<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteTemporaryUploadsCommand extends Command
{
    protected $signature = 'delete:temporary-uploads {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Delete old temporary uploads';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info('Start removing old temporary uploads...');

            $temporaryUploadModelClass = config('media-library.temporary_upload_model');

            $temporaryUploads = $temporaryUploadModelClass::old()->get();

            $temporaryUploads->each->delete();

            $this->comment($temporaryUploads->count().' old temporary upload(s) deleted!');
        });
    }
}
