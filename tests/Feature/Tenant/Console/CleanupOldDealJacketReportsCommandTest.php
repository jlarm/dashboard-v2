<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

beforeEach(function (): void {
    Carbon::setTestNow('2026-06-15 12:00:00');

    $this->reportsDir = storage_path('app/deal-jacket-reports');
    if (! File::isDirectory($this->reportsDir)) {
        File::makeDirectory($this->reportsDir, 0755, true);
    }

    // Clean any stragglers from previous runs.
    foreach (File::files($this->reportsDir) as $file) {
        if (str_starts_with($file->getFilename(), 'cleanup-test-')) {
            File::delete($file->getPathname());
        }
    }
});

afterEach(function (): void {
    Carbon::setTestNow();

    if (isset($this->reportsDir) && File::isDirectory($this->reportsDir)) {
        foreach (File::files($this->reportsDir) as $file) {
            if (str_starts_with($file->getFilename(), 'cleanup-test-')) {
                File::delete($file->getPathname());
            }
        }
    }
});

it('deletes deal-jacket reports older than 24 hours', function (): void {
    $oldFile = $this->reportsDir.'/cleanup-test-old-'.uniqid().'.pdf';
    $freshFile = $this->reportsDir.'/cleanup-test-fresh-'.uniqid().'.pdf';

    File::put($oldFile, 'old-bytes');
    File::put($freshFile, 'fresh-bytes');

    // Backdate the old file's mtime to 25h ago.
    touch($oldFile, now()->subHours(25)->timestamp);
    touch($freshFile, now()->subMinutes(30)->timestamp);

    tenancy()->end();
    $this->artisan('deal-jacket-reports:clean', ['--tenants' => [$this->tenant->id]])
        ->assertSuccessful();

    expect(File::exists($oldFile))->toBeFalse();
    expect(File::exists($freshFile))->toBeTrue();
});

it('keeps reports younger than 24 hours', function (): void {
    $file = $this->reportsDir.'/cleanup-test-young-'.uniqid().'.pdf';
    File::put($file, 'bytes');
    touch($file, now()->subHours(23)->timestamp);

    tenancy()->end();
    $this->artisan('deal-jacket-reports:clean', ['--tenants' => [$this->tenant->id]])
        ->assertSuccessful();

    expect(File::exists($file))->toBeTrue();
});

it('reports a missing directory message when no reports dir exists', function (): void {
    // Move directory aside, then run the command.
    $backup = $this->reportsDir.'-bak-'.uniqid();
    rename($this->reportsDir, $backup);

    try {
        tenancy()->end();
        $this->artisan('deal-jacket-reports:clean', ['--tenants' => [$this->tenant->id]])
            ->expectsOutputToContain('Deal Jacket Reports directory does not exist')
            ->assertSuccessful();
    } finally {
        if (File::isDirectory($backup)) {
            rename($backup, $this->reportsDir);
        }
    }
});
