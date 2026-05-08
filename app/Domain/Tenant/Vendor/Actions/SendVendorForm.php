<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Actions;

use App\Domain\Tenant\Vendor\Data\SendVendorFormData;
use App\Jobs\SendVendorEmailJob;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;

class SendVendorForm
{
    public function handle(Vendor $vendor, SendVendorFormData $data): VendorForm
    {
        /** @var VendorForm $vendorForm */
        $vendorForm = $vendor->forms()->create([
            'name' => $data->name,
            'email' => $data->email,
            'last_notification_sent_at' => now(),
        ]);

        dispatch(new SendVendorEmailJob($vendorForm));

        return $vendorForm;
    }
}
