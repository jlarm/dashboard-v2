<?php

declare(strict_types=1);

namespace App\Domain\Tenant\FitTests\Actions;

use App\Models\FitTestDoc;
use Illuminate\Support\Facades\Storage;

class DeleteFitTest
{
    public function handle(FitTestDoc $fitTestDoc): void
    {
        if ($fitTestDoc->file_path !== '') {
            Storage::disk('dealer-docs')->delete($fitTestDoc->file_path);
        }

        $fitTestDoc->delete();
    }
}
