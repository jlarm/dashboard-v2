<?php

declare(strict_types=1);

namespace App\Domain\Central\Sds\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class SdsStorage
{
    private const string DISK = 'sds-sheets';

    /**
     * @throws Throwable
     */
    public function store(UploadedFile $file): string
    {
        $fileName = $this->normaliseFileName($file->getClientOriginalName());

        $path = Storage::disk(self::DISK)->putFileAs('/', $file, $fileName);

        throw_unless($path, RuntimeException::class, 'File upload failed. Please try again.');

        return $fileName;
    }

    public function download(string $path, string $downloadName): StreamedResponse
    {
        return Storage::disk(self::DISK)->download($path, $downloadName);
    }

    public function delete(?string $path): void
    {
        if ($path !== null && $path !== '') {
            Storage::disk(self::DISK)->delete($path);
        }
    }

    private function normaliseFileName(string $fileName): string
    {
        return str_replace(' ', '-', $fileName);
    }
}
