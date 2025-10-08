<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

class CyrismaController extends Controller
{
    public function settings()
    {
        return view('tenant.scans.settings');
    }
}
