<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Actions;

use App\Mail\ComplianceFormMail;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendComplianceFormLink
{
    public function handle(Store $store, string $email): void
    {
        $signedUrl = URL::temporarySignedRoute(
            'dealer.dealer.settings.form',
            now()->addDays(4),
            ['store' => $store->id],
        );

        Mail::to($email)->send(new ComplianceFormMail($signedUrl, (string) $store->name));
    }
}
