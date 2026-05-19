<?php

declare(strict_types=1);

namespace App\Domain\Tenant\IndividualAudits\Data;

use App\Models\Dealer\Audit\IndividualAudit;

class IndividualAuditDetail
{
    /**
     * @param  array<int, array{id: int, uuid: string, audit_date: string, customer_name: ?string, customer_number: ?string, manager_name: ?string, draft: bool}>  $children
     * @param  array<string, mixed>  $answers
     * @param  array<int, array{id: int, url: string, preview_url: ?string}>  $images
     */
    public function __construct(
        public readonly int $id,
        public readonly string $uuid,
        public readonly ?int $parentId,
        public readonly string $auditDate,
        public readonly ?string $dealJacketDate,
        public readonly ?string $customerName,
        public readonly ?string $customerNumber,
        public readonly ?int $managerId,
        public readonly ?string $managerName,
        public readonly ?string $mileage,
        public readonly bool $draft,
        public readonly bool $hasPdf,
        public readonly string $storeName,
        public readonly string $quarter,
        public readonly int $year,
        public readonly array $children,
        public readonly array $answers,
        public readonly array $images,
    ) {}

    public static function fromModel(IndividualAudit $audit): self
    {
        $month = $audit->audit_date->month ?? 1;
        $quarter = match (true) {
            $month <= 3 => 'Q1',
            $month <= 6 => 'Q2',
            $month <= 9 => 'Q3',
            default => 'Q4',
        };

        $answers = [];
        for ($i = 1; $i <= 40; $i++) {
            $answers["q{$i}"] = [
                'answer' => $audit->{"individual_q{$i}_answer"} ?? null,
                'comment' => $audit->{"individual_q{$i}_comment"} ?? null,
                'danger' => (bool) ($audit->{"individual_q{$i}_danger"} ?? false),
            ];
        }

        $images = $audit->getMedia('individual_audit_images')->map(static fn (\Spatie\MediaLibrary\MediaCollections\Models\Media $media): array => [
            'id' => (int) $media->id,
            'url' => $media->getUrl(),
            'preview_url' => $media->hasGeneratedConversion('preview') ? $media->getUrl('preview') : null,
        ])->all();

        $children = $audit->children->map(static fn (IndividualAudit $child): array => [
            'id' => (int) $child->id,
            'uuid' => (string) $child->uuid,
            'audit_date' => $child->audit_date?->toDateString() ?? '',
            'customer_name' => $child->customer_name,
            'customer_number' => $child->customer_number,
            'manager_name' => $child->manager?->name,
            'draft' => (bool) $child->draft,
        ])->all();

        return new self(
            id: (int) $audit->id,
            uuid: (string) $audit->uuid,
            parentId: $audit->parent_id !== null ? (int) $audit->parent_id : null,
            auditDate: $audit->audit_date?->toDateString() ?? '',
            dealJacketDate: $audit->deal_jacket_date?->toDateString(),
            customerName: $audit->customer_name,
            customerNumber: $audit->customer_number,
            managerId: $audit->manager_id !== null ? (int) $audit->manager_id : null,
            managerName: $audit->manager?->name,
            mileage: $audit->mileage !== null ? (string) $audit->mileage : null,
            draft: (bool) $audit->draft,
            hasPdf: (bool) ($audit->pdf_path ?? false),
            storeName: (string) ($audit->store->name ?? ''),
            quarter: $quarter,
            year: (int) ($audit->audit_date->year ?? now()->year),
            children: $children,
            answers: $answers,
            images: $images,
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
            'parent_id' => $this->parentId,
            'audit_date' => $this->auditDate,
            'deal_jacket_date' => $this->dealJacketDate,
            'customer_name' => $this->customerName,
            'customer_number' => $this->customerNumber,
            'manager_id' => $this->managerId,
            'manager_name' => $this->managerName,
            'mileage' => $this->mileage,
            'draft' => $this->draft,
            'has_pdf' => $this->hasPdf,
            'store_name' => $this->storeName,
            'quarter' => $this->quarter,
            'year' => $this->year,
            'children' => $this->children,
            'answers' => $this->answers,
            'images' => $this->images,
        ];
    }
}
