<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\Contracts\Actions\CreateContract;
use App\Domain\Central\Contracts\Actions\DeleteContract;
use App\Domain\Central\Contracts\Actions\UpdateContract;
use App\Domain\Central\Contracts\Data\AdditionalLocationData;
use App\Domain\Central\Contracts\Data\ContractData;
use App\Domain\Central\Contracts\Queries\ListContractsForUser;
use App\Domain\Central\Contracts\Support\ContractSignatureStorage;
use App\Enums\Service;
use App\Http\Controllers\Controller;
use App\Http\Requests\Central\Contract\StoreContractRequest;
use App\Http\Requests\Central\Contract\UpdateContractRequest;
use App\Http\Resources\Central\ContractResource;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContractController extends Controller
{
    public function index(Request $request, ListContractsForUser $query): Response
    {
        $this->authorize('viewAny', Contract::class);

        /** @var User $user */
        $user = $request->user();

        return Inertia::render('central/contract/Index', [
            'contracts' => ContractResource::collection($query->handle($user)),
            'can' => [
                'create' => $user->can('create', Contract::class),
            ],
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', Contract::class);

        return Inertia::render('central/contract/Create', [
            'services' => $this->serviceOptions(),
        ]);
    }

    public function store(StoreContractRequest $request, CreateContract $action): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $contract = $action->handle($user, $this->contractData($request->validated()));

        return to_route('contracts.edit', $contract)
            ->with('flash.success', 'Contract created successfully.');
    }

    public function edit(Contract $contract, ContractSignatureStorage $signatures): Response
    {
        $this->authorize('view', $contract);

        $contract->load(['user', 'status']);

        return Inertia::render('central/contract/Edit', [
            'contract' => new ContractResource($contract)->resolve(),
            'consultants' => User::query()
                ->whereNot('name', 'Joe Lohr')
                ->orderBy('name')
                ->get(['id', 'name']),
            'services' => $this->serviceOptions(),
            'armp_signature_url' => $contract->armp_signature !== null
                ? $signatures->temporaryUrl($contract->armp_signature)
                : null,
            'can' => [
                'update' => request()->user()?->can('update', $contract) ?? false,
                'delete' => request()->user()?->can('delete', $contract) ?? false,
                'sendForReview' => request()->user()?->can('sendForReview', $contract) ?? false,
                'generatePdf' => request()->user()?->can('generatePdf', $contract) ?? false,
                'sendPdf' => request()->user()?->can('sendPdf', $contract) ?? false,
                'downloadPdf' => request()->user()?->can('downloadPdf', $contract) ?? false,
            ],
        ]);
    }

    public function update(UpdateContractRequest $request, Contract $contract, UpdateContract $action): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $action->handle($user, $contract, $this->contractData($request->validated()));

        return back()->with('flash.success', 'Contract updated successfully.');
    }

    public function destroy(Contract $contract, DeleteContract $action): RedirectResponse
    {
        $this->authorize('delete', $contract);

        $action->handle($contract);

        return to_route('contracts.index')->with('flash.success', 'Contract deleted.');
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function contractData(array $validated): ContractData
    {
        $locations = array_map(
            AdditionalLocationData::fromArray(...),
            $validated['additional_locations'] ?? [],
        );

        return new ContractData(
            userId: $validated['user_id'] ?? null,
            contractType: $validated['contract_type'],
            agreementDate: $validated['agreement_date'],
            dealerName: $validated['dealer_name'],
            services: $validated['services'],
            commenceDate: $validated['commence_date'],
            yearlyInspectionTotal: (int) $validated['yearly_inspection_total'],
            initialFee: (float) $validated['initial_fee'],
            monthlyFee: (float) $validated['monthly_fee'],
            additionalLocations: $locations,
            dealerPhysicalAddress: $validated['dealer_physical_address'] ?? null,
            dealerPhysicalCity: $validated['dealer_physical_city'] ?? null,
            dealerPhysicalState: $validated['dealer_physical_state'] ?? null,
            dealerPhysicalZip: $validated['dealer_physical_zip'] ?? null,
            dealerPhone: $validated['dealer_phone'] ?? null,
            dealerQiName: $validated['dealer_qi_name'] ?? null,
            dealerQiEmail: $validated['dealer_qi_email'] ?? null,
            dealerBillingAddress: $validated['dealer_billing_address'] ?? null,
            dealerBillingCity: $validated['dealer_billing_city'] ?? null,
            dealerBillingState: $validated['dealer_billing_state'] ?? null,
            dealerBillingZip: $validated['dealer_billing_zip'] ?? null,
            dealerBillingFax: $validated['dealer_billing_fax'] ?? null,
            dealerBillingContactName: $validated['dealer_billing_contact_name'] ?? null,
            dealerBillingContactTitle: $validated['dealer_billing_contact_title'] ?? null,
            dealerBillingContactEmail: $validated['dealer_billing_contact_email'] ?? null,
            armpPrintedName: $validated['armp_printed_name'] ?? null,
            armpSignature: $validated['armp_signature'] ?? null,
        );
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    private function serviceOptions(): array
    {
        return array_map(
            fn (Service $service): array => ['value' => $service->value, 'label' => $service->label()],
            Service::cases(),
        );
    }
}
