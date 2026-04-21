<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\Contracts\Actions\ReviewContract;
use App\Domain\Central\Contracts\Data\AdditionalLocationData;
use App\Domain\Central\Contracts\Data\ContractReviewData;
use App\Enums\Service;
use App\Http\Controllers\Controller;
use App\Http\Requests\Central\Contract\ReviewContractRequest;
use App\Models\Contract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContractReviewController extends Controller
{
    public function show(Request $request, Contract $contract): Response|RedirectResponse
    {
        if ($contract->dealer_printed_name !== null && $contract->dealer_printed_name !== '') {
            return to_route('contracts.thank-you');
        }

        return Inertia::render('contract/Review', [
            'signed_action_url' => $request->fullUrl(),
            'contract' => [
                'uuid' => $contract->uuid,
                'dealer_name' => $contract->dealer_name,
                'contract_type' => $contract->contract_type,
                'agreement_date' => $contract->agreement_date?->toDateString(),
                'agreement_date_day' => $contract->agreement_date?->format('jS'),
                'agreement_date_month' => $contract->agreement_date?->format('F'),
                'agreement_date_year' => $contract->agreement_date?->format('Y'),
                'commence_date_formatted' => $contract->commence_date?->format('F d, Y'),
                'yearly_inspection_total' => $contract->yearly_inspection_total,
                'initial_fee' => $contract->initial_fee,
                'monthly_fee' => $contract->monthly_fee,
                'services' => array_map(
                    fn (string $value): array => [
                        'value' => $value,
                        'label' => Service::tryFrom($value)?->label() ?? 'Unknown Service',
                    ],
                    (array) $contract->services,
                ),
                'dealer_physical_address' => $contract->dealer_physical_address,
                'dealer_physical_city' => $contract->dealer_physical_city,
                'dealer_physical_state' => $contract->dealer_physical_state,
                'dealer_physical_zip' => $contract->dealer_physical_zip,
                'dealer_phone' => $contract->dealer_phone,
                'dealer_qi_name' => $contract->dealer_qi_name,
                'dealer_qi_email' => $contract->dealer_qi_email,
                'dealer_billing_address' => $contract->dealer_billing_address,
                'dealer_billing_city' => $contract->dealer_billing_city,
                'dealer_billing_state' => $contract->dealer_billing_state,
                'dealer_billing_zip' => $contract->dealer_billing_zip,
                'dealer_billing_fax' => $contract->dealer_billing_fax,
                'dealer_billing_contact_name' => $contract->dealer_billing_contact_name,
                'dealer_billing_contact_title' => $contract->dealer_billing_contact_title,
                'dealer_billing_contact_email' => $contract->dealer_billing_contact_email,
                'additional_locations' => (array) ($contract->additional_locations ?? []),
            ],
        ]);
    }

    public function store(ReviewContractRequest $request, Contract $contract, ReviewContract $action): RedirectResponse
    {
        if ($contract->dealer_signature !== null && $contract->dealer_signature !== '') {
            return to_route('contracts.thank-you')
                ->with('flash.error', 'The contract has already been signed.');
        }

        $validated = $request->validated();

        $locations = array_map(
            fn (array $row): AdditionalLocationData => AdditionalLocationData::fromArray($row),
            $validated['additional_locations'] ?? [],
        );

        $action->handle($contract, new ContractReviewData(
            dealerPhysicalAddress: $validated['dealer_physical_address'],
            dealerPhysicalCity: $validated['dealer_physical_city'],
            dealerPhysicalState: $validated['dealer_physical_state'],
            dealerPhysicalZip: $validated['dealer_physical_zip'],
            dealerPhone: $validated['dealer_phone'],
            dealerQiName: $validated['dealer_qi_name'],
            dealerQiEmail: $validated['dealer_qi_email'],
            dealerBillingAddress: $validated['dealer_billing_address'],
            dealerBillingCity: $validated['dealer_billing_city'],
            dealerBillingState: $validated['dealer_billing_state'],
            dealerBillingZip: $validated['dealer_billing_zip'],
            dealerBillingContactName: $validated['dealer_billing_contact_name'],
            dealerBillingContactTitle: $validated['dealer_billing_contact_title'],
            dealerBillingContactEmail: $validated['dealer_billing_contact_email'],
            dealerPrintedName: $validated['dealer_printed_name'],
            dealerSignature: $validated['dealer_signature'],
            additionalLocations: $locations,
            dealerBillingFax: $validated['dealer_billing_fax'] ?? null,
        ));

        return to_route('contracts.thank-you');
    }
}
