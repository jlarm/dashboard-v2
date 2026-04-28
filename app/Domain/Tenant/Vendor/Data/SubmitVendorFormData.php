<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Data;

use Illuminate\Http\UploadedFile;

final readonly class SubmitVendorFormData
{
    /**
     * @param  array<int, array{response: string, comment: string|null}>|null  $responses
     */
    public function __construct(
        public ?UploadedFile $document,
        public ?string $signature,
        public ?array $responses,
    ) {}

    public function isDocumentUpload(): bool
    {
        return $this->document instanceof UploadedFile;
    }
}
