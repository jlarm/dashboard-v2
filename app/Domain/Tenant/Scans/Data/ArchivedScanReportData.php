<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

use App\Models\Dealer\ScanReport;

final readonly class ArchivedScanReportData
{
    private const string CDN_BASE_URL = 'https://armp-scan-reports.nyc3.cdn.digitaloceanspaces.com';

    public function __construct(
        public int $id,
        public string $type,
        public string $url,
        public string $createdAtFormatted,
    ) {}

    public static function fromModel(ScanReport $report): self
    {
        $createdAt = $report->created_at;

        return new self(
            id: $report->id,
            type: (string) $report->type,
            url: self::CDN_BASE_URL.'/'.$report->path,
            createdAtFormatted: $createdAt?->format('F d, Y') ?? 'Unknown',
        );
    }

    /**
     * @return array{id: int, type: string, url: string, created_at_formatted: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'url' => $this->url,
            'created_at_formatted' => $this->createdAtFormatted,
        ];
    }
}
