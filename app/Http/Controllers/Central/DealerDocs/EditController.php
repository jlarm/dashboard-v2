<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\DealerDocs;

use App\Http\Controllers\Controller;
use App\Models\SharedDocument;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class EditController extends Controller
{
    public function __invoke(SharedDocument $sharedDocument): Factory|View
    {
        return view('central.dealer-docs.edit', [
            'document' => $sharedDocument,
        ]);
    }
}
