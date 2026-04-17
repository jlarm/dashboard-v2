<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CyrismaController extends Controller
{
    public function index(): Factory|View
    {
        return view('tenant.scans.index');
    }

    public function settings(): Factory|View
    {
        return view('tenant.scans.settings');
    }
}
