<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

class PillarScoreData
{
    /**
     * @param  array<string, mixed>  $breakdown
     */
    public function __construct(
        public readonly string $key,
        public readonly string $label,
        public readonly bool $applicable,
        public readonly float $score,
        public readonly float $weight,
        public readonly array $breakdown = [],
        public readonly ?string $notApplicableReason = null,
    ) {}

    public static function notApplicable(string $key, string $label, string $reason): self
    {
        return new self(
            key: $key,
            label: $label,
            applicable: false,
            score: 0.0,
            weight: 0.0,
            notApplicableReason: $reason,
        );
    }

    public function withWeight(float $weight): self
    {
        return new self(
            key: $this->key,
            label: $this->label,
            applicable: $this->applicable,
            score: $this->score,
            weight: $weight,
            breakdown: $this->breakdown,
            notApplicableReason: $this->notApplicableReason,
        );
    }

    public function contribution(): float
    {
        return $this->applicable ? $this->score * $this->weight : 0.0;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'label' => $this->label,
            'applicable' => $this->applicable,
            'score' => round($this->score, 1),
            'weight' => round($this->weight, 4),
            'contribution' => round($this->contribution(), 2),
            'breakdown' => $this->breakdown,
            'not_applicable_reason' => $this->notApplicableReason,
        ];
    }
}
