<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Data;

final readonly class ContractData
{
    /**
     * @param  array<int, string>  $services
     * @param  array<int, AdditionalLocationData>  $additionalLocations
     */
    public function __construct(
        public ?int $userId,
        public string $contractType,
        public string $agreementDate,
        public string $dealerName,
        public array $services,
        public string $commenceDate,
        public int $yearlyInspectionTotal,
        public float $initialFee,
        public float $monthlyFee,
        public array $additionalLocations,
        public ?string $dealerPhysicalAddress = null,
        public ?string $dealerPhysicalCity = null,
        public ?string $dealerPhysicalState = null,
        public ?string $dealerPhysicalZip = null,
        public ?string $dealerPhone = null,
        public ?string $dealerQiName = null,
        public ?string $dealerQiEmail = null,
        public ?string $dealerBillingAddress = null,
        public ?string $dealerBillingCity = null,
        public ?string $dealerBillingState = null,
        public ?string $dealerBillingZip = null,
        public ?string $dealerBillingFax = null,
        public ?string $dealerBillingContactName = null,
        public ?string $dealerBillingContactTitle = null,
        public ?string $dealerBillingContactEmail = null,
        public ?string $armpPrintedName = null,
        public ?string $armpSignature = null,
    ) {}
}
