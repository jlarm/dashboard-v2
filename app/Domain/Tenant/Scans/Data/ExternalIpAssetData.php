<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

final readonly class ExternalIpAssetData
{
    /**
     * @param  list<array{port_number: string, port_description: ?string, risk_level: string}>  $openPorts
     * @param  list<array{name: string, risk_level: string, affected_urls: int, description: string, solution: string, references: list<string>, instances: list<array{url: string, method: string, parameters: string, attack: string, evidence: string}>}>  $findings
     */
    public function __construct(
        public string $name,
        public ?string $ipAddress,
        public array $openPorts,
        public array $findings,
        public int $criticalCount,
        public int $highCount,
        public int $mediumCount,
        public int $lowCount,
    ) {}

    public function totalFindings(): int
    {
        return $this->criticalCount + $this->highCount + $this->mediumCount + $this->lowCount;
    }

    public function tone(): string
    {
        if ($this->criticalCount > 0) {
            return 'critical';
        }

        if ($this->highCount >= 5) {
            return 'high';
        }

        if ($this->highCount > 0) {
            return 'medium';
        }

        if ($this->mediumCount > 0 || $this->lowCount > 0) {
            return 'low';
        }

        return 'clean';
    }

    /**
     * @return array{name: string, ip_address: ?string, open_ports: list<array{port_number: string, port_description: ?string, risk_level: string}>, findings: list<array{name: string, risk_level: string, affected_urls: int, description: string, solution: string, references: list<string>, instances: list<array{url: string, method: string, parameters: string, attack: string, evidence: string}>}>, counts: array{critical: int, high: int, medium: int, low: int, total: int}, tone: string}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'ip_address' => $this->ipAddress,
            'open_ports' => $this->openPorts,
            'findings' => $this->findings,
            'counts' => [
                'critical' => $this->criticalCount,
                'high' => $this->highCount,
                'medium' => $this->mediumCount,
                'low' => $this->lowCount,
                'total' => $this->totalFindings(),
            ],
            'tone' => $this->tone(),
        ];
    }
}
