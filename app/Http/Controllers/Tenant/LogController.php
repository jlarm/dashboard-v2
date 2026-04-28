<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ActivityLogResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    private const int PER_PAGE = 25;

    public function index(Request $request): InertiaResponse
    {
        $search = mb_trim((string) $request->string('search'));

        $logs = $this->paginatedLogs($search === '' ? null : $search);

        return Inertia::render('tenant/log/Index', [
            'logs' => ActivityLogResource::collection($logs),
            'filters' => [
                'search' => $search === '' ? null : $search,
            ],
        ]);
    }

    public function show(Activity $activity): ActivityLogResource
    {
        $activity->load(['causer', 'subject']);

        return new ActivityLogResource($activity);
    }

    private function paginatedLogs(?string $search): LengthAwarePaginator
    {
        return Activity::query()
            ->with('causer')
            ->when($search, fn ($query, $value) => $query->where(function ($inner) use ($value): void {
                $inner->where('description', 'like', "%{$value}%")
                    ->orWhere('event', 'like', "%{$value}%")
                    ->orWhere('subject_type', 'like', "%{$value}%")
                    ->orWhereHas('causer', fn ($causer) => $causer->where('name', 'like', "%{$value}%"));
            }))
            ->latest('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();
    }
}
