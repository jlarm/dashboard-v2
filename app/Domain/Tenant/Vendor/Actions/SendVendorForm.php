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
        $vendorForm = $vendor->forms()->create([
            'name' => $data->name,
            'email' => $data->email,
        ]);

        dispatch(new SendVendorEmailJob($vendorForm));

        return $vendorForm;
    }
}
