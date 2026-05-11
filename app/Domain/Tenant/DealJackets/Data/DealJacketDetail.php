<?php

declare(strict_types=1);

namespace App\Domain\Tenant\DealJackets\Data;

use App\Models\Dealer\Audit\DealJacket;

class DealJacketDetail
{
    /**
     * @param  array<int, array{statement: string, answer: ?string, high_risk: bool, comment: ?string}>  $responses
     */
    public function __construct(
        public readonly int $id,
        public readonly string $uuid,
        public readonly int $groupId,
        public readonly string $auditDate,
        public readonly string $dateOfDealJacket,
        public readonly ?string $customerName,
        public readonly ?string $customerDealNumber,
        public readonly ?int $userId,
        public readonly ?string $financeManagerName,
        public readonly ?string $mileage,
        public readonly ?string $purchaseType,
        public readonly ?string $vehicleType,
        public readonly array $responses,
        public readonly int $totalPassed,
        public readonly int $totalFailed,
        public readonly int $totalHighRisk,
        public readonly int $percentage,
    ) {}

    public static function fromModel(DealJacket $jacket): self
    {
        return new self(
            id: (int) $jacket->id,
            uuid: (string) $jacket->uuid,
            groupId: (int) $jacket->deal_jacket_group_id,
            auditDate: $jacket->audit_date?->toDateString() ?? '',
            dateOfDealJacket: $jacket->date_of_deal_jacket?->toDateString() ?? '',
            customerName: $jacket->customer_name,
            customerDealNumber: $jacket->customer_deal_number,
            userId: $jacket->user_id !== null ? (int) $jacket->user_id : null,
            financeManagerName: $jacket->user?->name,
            mileage: $jacket->mileage !== null ? (string) $jacket->mileage : null,
            purchaseType: $jacket->purchase_type,
            vehicleType: $jacket->vehicle_type,
            responses: array_map(static fn (array $r): array => [
                'statement' => (string) ($r['statement'] ?? ''),
                'answer' => isset($r['answer']) ? (string) $r['answer'] : null,
                'high_risk' => (bool) ($r['high_risk'] ?? false),
                'comment' => isset($r['comment']) ? (string) $r['comment'] : null,
            ], $jacket->responses ?? []),
            totalPassed: (int) $jacket->total_passed,
            totalFailed: (int) $jacket->total_failed,
            totalHighRisk: (int) $jacket->total_high_risk,
            percentage: (int) $jacket->percentage,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'group_id' => $this->groupId,
            'audit_date' => $this->auditDate,
            'date_of_deal_jacket' => $this->dateOfDealJacket,
            'customer_name' => $this->customerName,
            'customer_deal_number' => $this->customerDealNumber,
            'user_id' => $this->userId,
            'finance_manager_name' => $this->financeManagerName,
            'mileage' => $this->mileage,
            'purchase_type' => $this->purchaseType,
            'vehicle_type' => $this->vehicleType,
            'responses' => $this->responses,
            'total_passed' => $this->totalPassed,
            'total_failed' => $this->totalFailed,
            'total_high_risk' => $this->totalHighRisk,
            'percentage' => $this->percentage,
        ];
    }
}
