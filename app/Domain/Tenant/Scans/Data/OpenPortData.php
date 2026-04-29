<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Data;

final readonly class OpenPortData
{
    public function __construct(
        public string $portNumber,
        public ?string $portDescription,
        public string $riskLevel,
        public int $machineCount,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromPayload(array $payload): self
    {
        return new self(
            portNumber: (string) ($payload['portNumber'] ?? '-'),
            portDescription: isset($payload['portDescription']) && $payload['portDescription'] !== ''
                ? (string) $payload['portDescription']
                : null,
            riskLevel: (string) ($payload['riskLevel'] ?? 'Unknown'),
            machineCount: isset($payload['machineCount']) && is_numeric($payload['machineCount'])
                ? (int) $payload['machineCount']
                : 0,
        );
    }

    /**
     * @return array{port_number: string, port_description: ?string, risk_level: string, machine_count: int}
     */
    public function toArray(): array
    {
        return [
            'port_number' => $this->portNumber,
            'port_description' => $this->portDescription,
            'risk_level' => $this->riskLevel,
            'machine_count' => $this->machineCount,
        ];
    }
}
