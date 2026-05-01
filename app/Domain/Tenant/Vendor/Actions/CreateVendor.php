<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Actions;

use App\Domain\Tenant\Vendor\Data\CreateVendorData;
use App\Jobs\SendVendorEmailJob;
use App\Models\Dealer\Vendor;

class CreateVendor
{
    public function handle(CreateVendorData $data): Vendor
    {
        $vendor = Vendor::query()->create([
            'name' => $data->name,
            'contact_name' => $data->contactName,
            'contact_email' => $data->contactEmail,
            'store_id' => $data->storeId,
        ]);

        $vendorForm = $vendor->forms()->create([
            'name' => $vendor->contact_name,
            'email' => $vendor->contact_email,
            'last_notification_sent_at' => now(),
        ]);

        dispatch(new SendVendorEmailJob($vendorForm));

        return $vendor;
    }
}
