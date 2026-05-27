<?php

declare(strict_types=1);

use App\Jobs\CreateFrameworkDirectoriesForTenantJob;
use Illuminate\Support\Facades\File;

it('creates the framework/cache directory under the tenant storage path on handle()', function (): void {
    // Wipe any cache dir created by previous tests so the assertion is meaningful.
    $cachePath = $this->tenant->run(fn (): string => storage_path('framework/cache'));
    if (File::exists($cachePath)) {
        File::deleteDirectory($cachePath);
    }
    expect(File::exists($cachePath))->toBeFalse();

    new CreateFrameworkDirectoriesForTenantJob($this->tenant)->handle();

    expect(File::exists($cachePath))->toBeTrue();
    expect(File::isDirectory($cachePath))->toBeTrue();
});

it('is a no-op when the framework/cache directory already exists', function (): void {
    $cachePath = $this->tenant->run(fn (): string => storage_path('framework/cache'));
    File::ensureDirectoryExists($cachePath, 0o777, true);

    expect(fn () => new CreateFrameworkDirectoriesForTenantJob($this->tenant)->handle())
        ->not->toThrow(Throwable::class);

    expect(File::isDirectory($cachePath))->toBeTrue();
});
