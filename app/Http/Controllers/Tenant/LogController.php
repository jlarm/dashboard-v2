<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Log\Data\ActivityLogData;
use App\Domain\Tenant\Log\Queries\GetActivityLogs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Log\IndexActivityLogsRequest;
use App\Http\Resources\Tenant\ActivityLogResource;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index(IndexActivityLogsRequest $request, GetActivityLogs $getActivityLogs): InertiaResponse
    {
        $search = $request->search();

        return Inertia::render('tenant/log/Index', [
            'logs' => ActivityLogResource::collection($getActivityLogs->handle($search, $request->page())),
            'filters' => [
                'search' => $search === '' ? null : $search,
            ],
        ]);
    }

    public function show(Activity $activity): ActivityLogResource
    {
        $activity->load(['causer', 'subject']);

        return new ActivityLogResource(ActivityLogData::fromModel($activity)->toArray());
    }
}
