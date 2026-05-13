<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

final readonly class LocationGradeRowData
{
    public function __construct(
        public int $store_id,
        public string $store_name,
        public ?string $overall,
        public ?string $deal_jacket,
        public ?string $osha,
        public ?string $glba,
        public ?string $body_shop,
    ) {}

    /**
     * @return array{store_id:int, store_name:string, overall:?string, deal_jacket:?string, osha:?string, glba:?string, body_shop:?string}
     */
    public function toArray(): array
    {
        return [
            'store_id' => $this->store_id,
            'store_name' => $this->store_name,
            'overall' => $this->overall,
            'deal_jacket' => $this->deal_jacket,
            'osha' => $this->osha,
            'glba' => $this->glba,
            'body_shop' => $this->body_shop,
        ];
    }
}
