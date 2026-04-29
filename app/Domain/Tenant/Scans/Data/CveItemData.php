<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

final readonly class CveItemData
{
    public function __construct(
        public string $id,
        public string $title,
        public string $risk,
        public ?float $score,
        public ?string $publishedDate,
        public ?string $affectedTargets,
        public ?int $numAffectedTargets,
        public string $type,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromPayload(array $payload): self
    {
        return new self(
            id: (string) ($payload['id'] ?? 'Unknown'),
            title: (string) ($payload['title'] ?? 'Unknown'),
            risk: (string) ($payload['cve_risk'] ?? 'Unknown'),
            score: isset($payload['cve_score']) && is_numeric($payload['cve_score']) ? (float) $payload['cve_score'] : null,
            publishedDate: self::stringOrNull($payload, 'published_date'),
            affectedTargets: self::stringOrNull($payload, 'affected_targets'),
            numAffectedTargets: isset($payload['num_affected_targets']) && is_numeric($payload['num_affected_targets'])
                ? (int) $payload['num_affected_targets']
                : null,
            type: (string) ($payload['type'] ?? 'cve'),
        );
    }

    /**
     * @return array{id: string, title: string, risk: string, score: ?float, published_date: ?string, affected_targets: ?string, num_affected_targets: ?int, type: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'risk' => $this->risk,
            'score' => $this->score,
            'published_date' => $this->publishedDate,
            'affected_targets' => $this->affectedTargets,
            'num_affected_targets' => $this->numAffectedTargets,
            'type' => $this->type,
        ];
    }

    private static function stringOrNull(array $payload, string $key): ?string
    {
        if (! isset($payload[$key])) {
            return null;
        }

        $value = (string) $payload[$key];

        return $value === '' || $value === '-' ? null : $value;
    }
}
