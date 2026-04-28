<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Sds\Actions;

use App\Domain\Tenant\Sds\Data\RequestSdsSheetData;
use App\Mail\Tenant\SdsRequestMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class RequestSdsSheet
{
    public function handle(RequestSdsSheetData $data): void
    {
        $superAdminEmails = User::query()->role('super-admin')->pluck('email')->all();

        if ($superAdminEmails === []) {
            return;
        }

        Mail::to($superAdminEmails)->queue(new SdsRequestMail(
            chemicalName: $data->chemicalName,
            manufacturer: $data->manufacturer,
            requesterName: $data->requesterName,
            requesterEmail: $data->requesterEmail,
            tenantName: (string) tenant('name'),
        ));
    }
}
