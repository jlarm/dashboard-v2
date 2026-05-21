<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Log\Queries;

use App\Domain\Tenant\Log\Data\ActivityLogData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;

class GetActivityLogs
{
    private const int PER_PAGE = 25;

    /**
     * @return LengthAwarePaginator<int, mixed>
     */
    public function handle(string $search = '', int $page = 1): LengthAwarePaginator
    {
        $search = mb_trim($search);

        return Activity::query()
            ->with('causer:id,name')
            ->when($search !== '', static function (Builder $query) use ($search): void {
                $query->where(static function (Builder $inner) use ($search): void {
                    $inner->where('description', 'like', "%{$search}%")
                        ->orWhere('event', 'like', "%{$search}%")
                        ->orWhere('subject_type', 'like', "%{$search}%")
                        ->orWhereHas('causer', static fn (Builder $causer) => $causer->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest('id')
            ->paginate(perPage: self::PER_PAGE, page: $page)
            ->through(static fn (Activity $activity): array => ActivityLogData::fromModel($activity)->toArray())
            ->withQueryString();
    }
}
