<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Sds\Queries;

use App\Domain\Tenant\Sds\Data\SdsRecordData;
use App\Models\Sds;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

/**
 * Searches the central Sds catalog. Tenant users only ever see records
 * from the central database (the catalog is shared dealer-wide).
 */
class SearchSdsRecords
{
    /**
     * @var array<int, string>
     */
    public const array ALLOWED_SORT_FIELDS = ['name', 'manufacturer'];

    private const int PER_PAGE = 25;

    /**
     * @var array<int, string>
     */
    private const array SELECT_COLUMNS = ['id', 'uuid', 'name', 'manufacturer'];

    /**
     * @return LengthAwarePaginator<int, array<string, mixed>>
     */
    public function handle(string $search, string $sort = 'name', string $direction = 'asc'): LengthAwarePaginator
    {
        /** @phpstan-ignore return.type */
        return tenancy()->central(fn (): LengthAwarePaginator => Sds::query()
            ->where(function (Builder $query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('manufacturer', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%")
                    ->orWhereJsonContains('keywords', $search);
            })
            ->orderBy($sort, $direction)
            ->when($sort !== 'name', fn (Builder $query) => $query->orderBy('name'))
            ->paginate(perPage: self::PER_PAGE, columns: self::SELECT_COLUMNS)
            ->through(static fn (Sds $sds): array => SdsRecordData::fromModel($sds)->toArray())
            ->withQueryString());
    }
}
