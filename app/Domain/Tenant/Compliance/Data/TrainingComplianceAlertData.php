<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

final readonly class TrainingComplianceAlertData
{
    public function __construct(
        public string $user_slug,
        public string $name,
        public int $valid_completed,
        public int $total_required,
        public string $status,
    ) {}

    /**
     * @return array{user_slug:string, name:string, valid_completed:int, total_required:int, status:string}
     */
    public function toArray(): array
    {
        return [
            'user_slug' => $this->user_slug,
            'name' => $this->name,
            'valid_completed' => $this->valid_completed,
            'total_required' => $this->total_required,
            'status' => $this->status,
        ];
    }
}
