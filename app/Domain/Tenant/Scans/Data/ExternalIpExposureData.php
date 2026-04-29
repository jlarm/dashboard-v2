<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

final readonly class ExternalIpExposureData
{
    /**
     * @param  list<array<string, mixed>>  $assets
     */
    public function __construct(
        public ?string $lastScanFinished,
        public array $assets,
    ) {}

    /**
     * @return array{last_scan_finished: ?string, assets: list<array<string, mixed>>}
     */
    public function toArray(): array
    {
        return [
            'last_scan_finished' => $this->lastScanFinished,
            'assets' => $this->assets,
        ];
    }
}
