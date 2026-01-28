<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\DealerDocs;

use App\Http\Controllers\Controller;
use App\Models\SharedDocument;

class EditController extends Controller
{
    public function __invoke(SharedDocument $sharedDocument)
    {
        return view('central.dealer-docs.edit', [
            'document' => $sharedDocument,
        ]);
    }
}
