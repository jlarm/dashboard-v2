<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Actions;

use App\Domain\Central\Contracts\Data\AdditionalLocationData;
use App\Domain\Central\Contracts\Data\ContractData;
use App\Domain\Central\Contracts\Support\ContractSignatureStorage;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateContract
{
    public function __construct(
        private readonly AppendContractStatus $appendStatus,
        private readonly ContractSignatureStorage $signatures,
    ) {}

    public function handle(User $user, Contract $contract, ContractData $data): Contract
    {
        return DB::transaction(function () use ($user, $contract, $data): Contract {
            $contract->update([
                'user_id' => $data->userId ?? $contract->user_id,
                'contract_type' => $data->contractType,
                'agreement_date' => $data->agreementDate,
                'dealer_name' => $data->dealerName,
                'services' => $data->services,
                'commence_date' => $data->commenceDate,
                'yearly_inspection_total' => $data->yearlyInspectionTotal,
                'initial_fee' => $data->initialFee,
                'monthly_fee' => $data->monthlyFee,
                'armp_printed_name' => $data->armpPrintedName,
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
                'additional_locations' => array_map(
                    fn (AdditionalLocationData $location): array => $location->toArray(),
                    $data->additionalLocations,
                ),
            ]);

            if ($data->armpSignature !== null && $data->armpSignature !== '' && $contract->armp_signature === null) {
                $path = $this->signatures->storeDataUri($contract, $data->armpSignature);

                $contract->update([
                    'armp_signature' => $path,
                    'armp_date_signed' => now(),
                ]);

                $this->appendStatus->handle($contract, $user->name ?? '', 'signed the contract', 4);
            }

            $this->appendStatus->handle($contract, $user->name ?? '', 'updated contract');

            return $contract->refresh();
        });
    }
}
