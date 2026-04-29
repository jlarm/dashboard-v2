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
        }

        if ($manual->signature !== null && $manual->signature !== '') {
            Storage::delete('isp-signatures/'.$manual->signature);
        }

        $manual->delete();
    }
}
