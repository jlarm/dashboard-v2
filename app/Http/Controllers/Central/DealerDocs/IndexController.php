<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\DealerDocs;

use App\Http\Controllers\Controller;
use App\Models\DealerDoc;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __invoke(): View
    {
        Gate::authorize('view-any', DealerDoc::class);

        return view('central.dealer-docs.index');
    }
}
