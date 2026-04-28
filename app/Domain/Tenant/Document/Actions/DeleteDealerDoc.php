<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Document\Actions;

use App\Models\DealerDoc;
use Illuminate\Support\Facades\Storage;

class DeleteDealerDoc
{
    public function handle(DealerDoc $dealerDoc): void
    {
        if ($dealerDoc->file_path !== null && $dealerDoc->file_path !== '') {
            Storage::disk('dealer-docs')->delete($dealerDoc->file_path);
        }

        $dealerDoc->delete();
    }
}
