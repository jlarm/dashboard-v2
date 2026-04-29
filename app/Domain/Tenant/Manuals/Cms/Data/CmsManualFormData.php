<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Cms\Data;

final readonly class CmsManualFormData
{
    public function __construct(
        public string $qiName,
        public string $standardDppRate,
        public ?string $adoptionApprovalNameOne,
        public ?string $adoptionApprovalSignatureOne,
        public ?string $adoptionApprovalNameTwo,
        public ?string $adoptionApprovalSignatureTwo,
        public ?string $adoptionApprovalNameThree,
        public ?string $adoptionApprovalSignatureThree,
        public ?string $dealerParticipationName,
        public ?string $dealerParticipationSignature,
        public string $acknowledgementName,
        public string $acknowledgementSignature,
    ) {}
}
