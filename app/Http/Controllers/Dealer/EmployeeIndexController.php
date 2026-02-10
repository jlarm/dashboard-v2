<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Store;
use Illuminate\View\View;

class EmployeeIndexController extends Controller
{
    public function __invoke(): View
    {
        return view('dealer.employee.index', [
            'stores' => Store::query()->count(),
        ]);
    }
}
