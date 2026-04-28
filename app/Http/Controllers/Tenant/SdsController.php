<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Sds\Actions\RequestSdsSheet;
use App\Domain\Tenant\Sds\Queries\SearchSdsRecords;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Sds\IndexSdsRecordsRequest;
use App\Http\Requests\Tenant\Sds\RequestSdsSheetRequest;
use App\Http\Resources\Tenant\SdsRecordResource;
use App\Models\Sds;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class SdsController extends Controller
{
    public function index(IndexSdsRecordsRequest $request, SearchSdsRecords $searchSdsRecords): InertiaResponse
    {
        $search = $request->search();
        $sort = $request->sort();
        $direction = $request->direction();

        $records = $search === ''
            ? null
            : SdsRecordResource::collection($searchSdsRecords->handle($search, $sort, $direction));

        return Inertia::render('tenant/sds/Index', [
            'records' => $records,
            'filters' => [
                'search' => $search === '' ? null : $search,
                'sort' => $sort,
                'direction' => $direction,
            ],
        ]);
    }

    public function view(string $uuid): Response
    {
        return tenancy()->central(function () use ($uuid): Response {
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

    public function storeRequest(RequestSdsSheetRequest $request, RequestSdsSheet $requestSdsSheet): RedirectResponse
    {
        $requestSdsSheet->handle($request->toData());

        return back()->with('flash.success', 'Request successfully sent.');
    }
}
