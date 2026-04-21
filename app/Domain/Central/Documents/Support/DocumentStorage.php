<?php

declare(strict_types=1);

namespace App\Domain\Central\Documents\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class DocumentStorage
{
    /**
     * @throws Throwable
     */
    public function store(UploadedFile $file): string
    {
        $path = Storage::disk('central-docs')->putFileAs(
            '/',
            $file,
            $file->getClientOriginalName(),
        );

        throw_unless($path, RuntimeException::class, 'File upload failed. Please try again.');

        return $path;
    }

    public function response(string $path): StreamedResponse
    {
        return Storage::disk('central-docs')->response($path);
    }

    public function delete(?string $path): void
    {
        if ($path !== null && $path !== '') {
            Storage::disk('central-docs')->delete($path);
        }
    }
}
