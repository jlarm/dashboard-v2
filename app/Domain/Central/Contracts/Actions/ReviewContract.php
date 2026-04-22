<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Actions;

use App\Domain\Central\Contracts\Data\AdditionalLocationData;
use App\Domain\Central\Contracts\Data\ContractReviewData;
use App\Domain\Central\Contracts\Support\ContractSignatureStorage;
use App\Models\Contract;
use App\Notifications\ContractSignedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use RuntimeException;

class ReviewContract
{
    public function __construct(
        private readonly AppendContractStatus $appendStatus,
        private readonly ContractSignatureStorage $signatures,
    ) {}

    public function handle(Contract $contract, ContractReviewData $data): Contract
    {
        return DB::transaction(function () use ($contract, $data): Contract {
            throw_if($contract->dealer_signature !== null && $contract->dealer_signature !== '', RuntimeException::class, 'The contract has already been signed.');

            $signaturePath = $this->signatures->storeDataUri($contract, $data->dealerSignature);

            $contract->update([
                'dealer_physical_address' => $data->dealerPhysicalAddress,
                'dealer_physical_city' => $data->dealerPhysicalCity,
                'dealer_physical_state' => $data->dealerPhysicalState,
                'dealer_physical_zip' => $data->dealerPhysicalZip,
                'dealer_phone' => $data->dealerPhone,
                'dealer_qi_name' => $data->dealerQiName,
                'dealer_qi_email' => $data->dealerQiEmail,
                'dealer_billing_address' => $data->dealerBillingAddress,
                'dealer_billing_city' => $data->dealerBillingCity,
                'dealer_billing_state' => $data->dealerBillingState,
                'dealer_billing_zip' => $data->dealerBillingZip,
                'dealer_billing_fax' => $data->dealerBillingFax,
                'dealer_billing_contact_name' => $data->dealerBillingContactName,
                'dealer_billing_contact_title' => $data->dealerBillingContactTitle,
                'dealer_billing_contact_email' => $data->dealerBillingContactEmail,
                'dealer_printed_name' => $data->dealerPrintedName,
                'dealer_date_signed' => now(),
                'dealer_signature' => $signaturePath,
                'additional_locations' => array_map(
                    fn (AdditionalLocationData $location): array => $location->toArray(),
                    $data->additionalLocations,
                ),
            ]);

            $this->appendStatus->handle($contract, $data->dealerPrintedName, 'signed the contract', 3);

            Notification::route('mail', 'tdortch@autorisknow.com')
                ->notify(new ContractSignedNotification($contract));

            if ($contract->user?->email !== null) {
                Notification::route('mail', $contract->user->email)
                    ->notify(new ContractSignedNotification($contract));
            }

            return $contract->refresh();
        });
    }
}
