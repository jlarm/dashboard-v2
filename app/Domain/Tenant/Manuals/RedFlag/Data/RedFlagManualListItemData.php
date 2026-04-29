<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\RedFlag\Data;

final readonly class RedFlagManualListItemData
{
    public function __construct(
        public int $id,
        public string $signedAt,
        public string $signedAtIso,
        public string $signedByName,
        public string $storeName,
        public ?string $downloadUrl,
    ) {}

    /**
     * @return array{
     *     id: int,
     *     signed_at: string,
     *     signed_at_iso: string,
     *     signed_by_name: string,
     *     store_name: string,
     *     download_url: ?string,
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'signed_at' => $this->signedAt,
            'signed_at_iso' => $this->signedAtIso,
            'signed_by_name' => $this->signedByName,
            'store_name' => $this->storeName,
            'download_url' => $this->downloadUrl,
        ];
    }
}
