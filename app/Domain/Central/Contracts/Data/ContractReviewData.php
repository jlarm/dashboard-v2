<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Data;

final readonly class ContractReviewData
{
    /**
     * @param  array<int, AdditionalLocationData>  $additionalLocations
     */
    public function __construct(
        public string $dealerPhysicalAddress,
        public string $dealerPhysicalCity,
        public string $dealerPhysicalState,
        public string $dealerPhysicalZip,
        public string $dealerPhone,
        public string $dealerQiName,
        public string $dealerQiEmail,
        public string $dealerBillingAddress,
        public string $dealerBillingCity,
        public string $dealerBillingState,
        public string $dealerBillingZip,
        public string $dealerBillingContactName,
        public string $dealerBillingContactTitle,
        public string $dealerBillingContactEmail,
        public string $dealerPrintedName,
        public string $dealerSignature,
        public array $additionalLocations,
        public ?string $dealerBillingFax = null,
    ) {}
}
