<?php

namespace App\Http\Controllers\Central\DealerDocs;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\DealerDoc;

class IndexController extends Controller
{
    public function __invoke(): View
    {
        $this->authorize('view-any', DealerDoc::class);

        return view('central.dealer-docs.index');
    }
}
