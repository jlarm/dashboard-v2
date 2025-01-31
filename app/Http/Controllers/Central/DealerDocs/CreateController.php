<?php

namespace App\Http\Controllers\Central\DealerDocs;

use App\Http\Controllers\Controller;
use App\Models\DealerDoc;
use Illuminate\View\View;

class CreateController extends Controller
{
    public function __invoke(): View
    {
        $this->authorize('create', DealerDoc::class);

        return view('central.dealer-docs.create');
    }
}
