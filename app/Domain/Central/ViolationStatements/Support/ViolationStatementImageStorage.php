<?php

declare(strict_types=1);

namespace App\Domain\Central\ViolationStatements\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ViolationStatementImageStorage
{
    private const string DISK = 'digitalocean';

    private const string DIRECTORY = 'violation-statements';

    public function store(UploadedFile $file): string
    {
        $path = $file->storePublicly(self::DIRECTORY, self::DISK);

        throw_if($path === false, RuntimeException::class, 'Failed to store violation statement image.');

        return Storage::disk(self::DISK)->url($path);
    }

    public function delete(?string $url): void
    {
        if ($url === null || $url === '') {
            return;
        }

        $path = parse_url($url, PHP_URL_PATH);

        if (! is_string($path) || $path === '') {
            return;
        }

        Storage::disk(self::DISK)->delete(mb_ltrim($path, '/'));
    }
}
