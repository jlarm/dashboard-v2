<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Search\Data;

use Illuminate\Contracts\Support\Arrayable;

/**
 * A single hit in the global search palette.
 *
 * @implements Arrayable<string, mixed>
 */
final readonly class SearchResultData implements Arrayable
{
    public function __construct(
        public string $type,
        public string $id,
        public string $title,
        public string $subtitle,
        public string $url,
    ) {}

    /**
     * @return array{type: string, id: string, title: string, subtitle: string, url: string}
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'url' => $this->url,
        ];
    }
}
