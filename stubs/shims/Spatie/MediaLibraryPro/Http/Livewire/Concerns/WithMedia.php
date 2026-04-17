<?php

declare(strict_types=1);

namespace Spatie\MediaLibraryPro\Http\Livewire\Concerns;

/**
 * Compatibility shim for removed spatie/laravel-medialibrary-pro trait.
 * Upload flows are no-op until components are migrated to Flux upload components.
 */
trait WithMedia
{
    public array $mediaComponentNames = [];

    public function syncMedia(): array
    {
        return [];
    }

    public function getMedia(string $collection = 'default'): array
    {
        return [];
    }

    public function validateMedia(): void
    {
        //
    }

    public function registerMediaComponent(string $statePath): void
    {
        $this->mediaComponentNames[] = $statePath;
    }
}
