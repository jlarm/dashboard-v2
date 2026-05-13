<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Store\Actions;

use App\Models\Dealer\Store;

class UpdateConsultantNote
{
    public function handle(Store $store, ?string $note): void
    {
        $trimmed = $note === null ? null : mb_trim($note);

        $store->update([
            'note' => $trimmed === '' ? null : $trimmed,
        ]);
    }
}
