<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Storage;

describe('livewire:clear-temp-files', function (): void {
    it('iterates every tenant and reports the per-tenant header and the total summary', function (): void {
        $diskName = (string) (config('livewire.temporary_file_upload.disk') ?? config('filesystems.default', 'local'));
        Storage::fake($diskName);

        tenancy()->end();
        $this->artisan('livewire:clear-temp-files')
            ->expectsOutputToContain('Starting to clear Livewire temporary files for all tenants')
            ->expectsOutputToContain("Processing tenant {$this->tenant->id}")
            ->expectsOutputToContain('Total files deleted:')
            ->expectsOutputToContain('All done!')
            ->assertExitCode(0);
    });
});
