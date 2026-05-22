<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Queries;

use App\Domain\Tenant\Vendor\Data\VendorDetailData;
use App\Domain\Tenant\Vendor\Data\VendorFormData;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;

class GetVendorDetail
{
    /**
     * @return array{detail: VendorDetailData, forms: list<VendorFormData>}
     */
    public function handle(Vendor $vendor): array
    {
        $vendor->loadMissing(['store:id,name']);

        $forms = $vendor->forms()
            ->with(['emailLogs:id,vendor_form_id,event_type,delivery_message,sent_at'])
            ->latest()
            ->take(20)
            ->get(['id', 'vendor_id', 'name', 'email', 'signature', 'document_path', 'created_at']);

        return [
            'detail' => VendorDetailData::fromModel($vendor),
            'forms' => array_values(
                $forms
                    ->map(static fn (VendorForm $form): VendorFormData => VendorFormData::fromModel($form))
                    ->all(),
            ),
        ];
    }
}
