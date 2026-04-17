<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Sds;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class SdsController extends Controller
{
    public function index(): Factory|View
    {
        return view('tenant.sds.index');
    }

    public function view(string $uuid): Response
    {
        return tenancy()->central(function () use ($uuid): ResponseFactory|Response {
            $sds = Sds::query()->where('uuid', $uuid)->firstOrFail();

            $fileContents = Storage::disk('sds-sheets')->get($sds->file_name);

            return response($fileContents, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$sds->name.'.pdf"',
                'Cache-Control' => 'public, max-age=31536000',
                'Expires' => now()->addYear()->format('D, d M Y H:i:s \G\M\T'),
            ]);
        });
    }
}
