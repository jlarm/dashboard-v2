<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\RedFlag\Actions;

use App\Models\Dealer\Manual\RedFlag;
use Illuminate\Support\Facades\Storage;

class DeleteRedFlagManual
{
    public function handle(RedFlag $manual): void
    {
        if ($manual->pdf_path !== null && $manual->pdf_path !== '') {
            Storage::disk('do-manuals')->delete(tenant('id').'/red-flags/'.$manual->pdf_path);
        }

        if ($manual->signature !== null && $manual->signature !== '') {
            Storage::delete('red-flag-signatures/'.$manual->signature);
        }

        $manual->delete();
    }
}
