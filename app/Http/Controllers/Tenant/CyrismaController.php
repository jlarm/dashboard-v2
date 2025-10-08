<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

class CyrismaController extends Controller
{
    public function index()
    {
        return view('tenant.scans.index');
    }

    public function settings()
    {
        return view('tenant.scans.settings');
    }
}
