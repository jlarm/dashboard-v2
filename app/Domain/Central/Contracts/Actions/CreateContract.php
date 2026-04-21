<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Actions;

use App\Domain\Central\Contracts\Data\AdditionalLocationData;
use App\Domain\Central\Contracts\Data\ContractData;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateContract
{
    public function __construct(
        private readonly AppendContractStatus $appendStatus,
    ) {}

    public function handle(User $user, ContractData $data): Contract
    {
        return DB::transaction(function () use ($user, $data): Contract {
            $contract = Contract::query()->create([
                'user_id' => $data->userId ?? $user->id,
                'contract_type' => $data->contractType,
                'agreement_date' => $data->agreementDate,
                'dealer_name' => Str::title($data->dealerName),
                'services' => $data->services,
                'commence_date' => $data->commenceDate,
                'yearly_inspection_total' => $data->yearlyInspectionTotal,
                'initial_fee' => $data->initialFee,
                'monthly_fee' => $data->monthlyFee,
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

            $this->appendStatus->handle($contract, $user->name ?? '', 'created contract', 1);

            return $contract;
        });
    }
}
