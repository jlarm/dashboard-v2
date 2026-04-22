<?php

declare(strict_types=1);

namespace App\Http\Resources\Central;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

class ContractResource extends JsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        $progress = $this->status
            ->pluck('step')
            ->filter(fn ($step): bool => $step !== null)
            ->unique()
            ->values();

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', fn (): array => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ]),
            'contract_type' => $this->contract_type,
            'agreement_date' => $this->agreement_date?->toDateString(),
            'commence_date' => $this->commence_date?->toDateString(),
            'dealer_name' => $this->dealer_name,
            'services' => (array) $this->services,
            'yearly_inspection_total' => $this->yearly_inspection_total,
            'initial_fee' => $this->initial_fee,
            'monthly_fee' => $this->monthly_fee,
            'armp_signature' => $this->armp_signature,
            'armp_printed_name' => $this->armp_printed_name,
            'armp_date_signed' => $this->armp_date_signed?->toDateString(),
            'dealer_signature' => $this->dealer_signature,
            'dealer_printed_name' => $this->dealer_printed_name,
            'dealer_date_signed' => $this->dealer_date_signed?->toDateString(),
            'dealer_physical_address' => $this->dealer_physical_address,
            'dealer_physical_city' => $this->dealer_physical_city,
            'dealer_physical_state' => $this->dealer_physical_state,
            'dealer_physical_zip' => $this->dealer_physical_zip,
            'dealer_phone' => $this->dealer_phone,
            'dealer_qi_name' => $this->dealer_qi_name,
            'dealer_qi_email' => $this->dealer_qi_email,
            'dealer_billing_address' => $this->dealer_billing_address,
            'dealer_billing_city' => $this->dealer_billing_city,
            'dealer_billing_state' => $this->dealer_billing_state,
            'dealer_billing_zip' => $this->dealer_billing_zip,
            'dealer_billing_fax' => $this->dealer_billing_fax,
            'dealer_billing_contact_name' => $this->dealer_billing_contact_name,
            'dealer_billing_contact_title' => $this->dealer_billing_contact_title,
            'dealer_billing_contact_email' => $this->dealer_billing_contact_email,
            'additional_locations' => (array) ($this->additional_locations ?? []),
            'pdf_path' => $this->pdf_path,
            'progress_steps' => $progress,
            'latest_step' => $progress->last(),
            'status' => $this->whenLoaded('status', fn () => ContractStatusResource::collection($this->status)->resolve()),
        ];
    }
}
