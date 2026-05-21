<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

final readonly class IssueCountsData
{
    public function __construct(
        public ?int $total,
        public ?int $critical,
        public ?int $high,
        public ?int $medium,
        public ?int $low,
        public ?string $grade,
    ) {}

    /**
     * @param  array<string, mixed>  $scan
     */
    public static function fromScan(array $scan): self
    {
        return new self(
            total: self::intOrNull($scan, 'vulnerabilities'),
            critical: self::intOrNull($scan, 'critical_vulnerabilities'),
            high: self::intOrNull($scan, 'high_vulnerabilities'),
            medium: self::intOrNull($scan, 'medium_vulnerabilities'),
            low: self::intOrNull($scan, 'low_vulnerabilities'),
            grade: isset($scan['grade_alpha']) && is_string($scan['grade_alpha']) ? $scan['grade_alpha'] : null,
        );
    }

    public static function empty(): self
    {
        return new self(null, null, null, null, null, null);
    }

    /**
     * @return array{total: ?int, critical: ?int, high: ?int, medium: ?int, low: ?int, grade: ?string}
     */
    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'critical' => $this->critical,
            'high' => $this->high,
            'medium' => $this->medium,
            'low' => $this->low,
            'grade' => $this->grade,
        ];
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private static function intOrNull(array $payload, string $key): ?int
    {
        if (! array_key_exists($key, $payload) || ! is_numeric($payload[$key])) {
            return null;
        }

        return (int) $payload[$key];
    }
}
