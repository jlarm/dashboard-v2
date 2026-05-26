<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Isp\Actions;

use App\Models\Dealer\Manual\Isp;
use Illuminate\Support\Facades\Storage;

class DeleteIspManual
{
    public function handle(Isp $manual): void
    {
        if ($manual->pdf_path !== null && $manual->pdf_path !== '') {
            Storage::disk('do-manuals')->delete(tenant('id').'/isp/'.$manual->pdf_path);
            // Generate*ManualJob stages the PDF under storage/app/ before the
            // Upload job moves it to do-manuals. If we're deleting the manual
            // mid-flight, the staging file would otherwise be orphaned.
            Storage::delete($manual->pdf_path);
        }

        if ($manual->signature !== null && $manual->signature !== '') {
            Storage::delete('isp-signatures/'.$manual->signature);
        }

        $manual->delete();
    }
}
