<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Osha\Actions;

use App\Models\Dealer\Manual\Osha;
use Illuminate\Support\Facades\Storage;

class DeleteOshaManual
{
    public function handle(Osha $manual): void
    {
        if ($manual->pdf_path !== null && $manual->pdf_path !== '') {
            Storage::disk('do-manuals')->delete(tenant('id').'/osha/'.$manual->pdf_path);
        }

        if ($manual->signature !== null && $manual->signature !== '') {
            Storage::delete('osha-signatures/'.$manual->signature);
        }

        $manual->delete();
    }
}
