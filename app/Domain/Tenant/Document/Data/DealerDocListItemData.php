<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Document\Data;

use App\Models\DealerDoc;
use App\Models\SharedDocument;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class DealerDocListItemData implements Arrayable
{
    public function __construct(
        public string $key,
        public int $id,
        public string $title,
        public ?string $url,
        public ?string $downloadUrl,
        public bool $isShared,
    ) {}

    public static function fromDealerDoc(DealerDoc $doc): self
    {
        $hasFile = $doc->file_path !== null && $doc->file_path !== '';

        return new self(
            key: "dealer-{$doc->id}",
            id: (int) $doc->id,
            title: (string) $doc->title,
            url: $doc->url,
            downloadUrl: $hasFile ? route('dealer.doc.download', $doc) : null,
            isShared: false,
        );
    }

    public static function fromSharedDocument(SharedDocument $doc): self
    {
        $hasFile = $doc->file_name !== null && $doc->file_name !== '';

        return new self(
            key: "shared-{$doc->id}",
            id: (int) $doc->id,
            title: (string) $doc->title,
            url: $doc->url,
            downloadUrl: $hasFile
                ? route('dealer.doc.shared.download', ['sharedDocument' => $doc->id])
                : null,
            isShared: true,
        );
    }

    /**
     * @return array{
     *     key: string,
     *     id: int,
     *     title: string,
     *     url: string|null,
     *     download_url: string|null,
     *     is_shared: bool
     * }
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'download_url' => $this->downloadUrl,
            'is_shared' => $this->isShared,
        ];
    }
}
