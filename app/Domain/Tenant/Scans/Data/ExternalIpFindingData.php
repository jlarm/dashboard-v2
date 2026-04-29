<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

final readonly class ExternalIpFindingData
{
    /**
     * @param  list<string>  $references
     * @param  list<array{url: string, method: string, parameters: string, attack: string, evidence: string}>  $instances
     */
    public function __construct(
        public string $name,
        public string $riskLevel,
        public int $affectedUrls,
        public string $description,
        public string $solution,
        public array $references,
        public array $instances,
    ) {}

    /**
     * @return array{name: string, risk_level: string, affected_urls: int, description: string, solution: string, references: list<string>, instances: list<array{url: string, method: string, parameters: string, attack: string, evidence: string}>}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'risk_level' => $this->riskLevel,
            'affected_urls' => $this->affectedUrls,
            'description' => $this->description,
            'solution' => $this->solution,
            'references' => $this->references,
            'instances' => $this->instances,
        ];
    }
}
