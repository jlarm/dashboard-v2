<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Document\Queries;

use App\Domain\Tenant\Document\Data\DealerDocListItemData;
use App\Models\DealerDoc;
use App\Models\SharedDocument;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator as PaginatorImpl;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Combines tenant DealerDoc rows with central SharedDocument rows into a
 * single sorted, paginated list.
 *
 * Pagination happens in PHP because the two sets live in separate
 * databases (tenant vs central) and can't be UNION'd at the SQL level.
 */
class GetDealerDocs
{
    private const int PER_PAGE = 15;

    /**
     * @var array<int, string>
     */
    private const array DEALER_DOC_COLUMNS = ['id', 'title', 'url', 'file_path'];

    /**
     * @var array<int, string>
     */
    private const array SHARED_DOCUMENT_COLUMNS = ['id', 'title', 'url', 'file_name'];

    /**
     * @return LengthAwarePaginator<int, mixed>
     */
    public function handle(string $search = '', int $page = 1): LengthAwarePaginator
    {
        $search = mb_trim($search);

        $merged = $this->dealerDocs($search)
            ->concat($this->sharedDocuments($search))
            ->sortBy(static fn (DealerDocListItemData $item): string => Str::lower($item->title))
            ->values();

        $items = $merged->forPage($page, self::PER_PAGE)
            ->map(static fn (DealerDocListItemData $item): array => $item->toArray())
            ->values();

        return new PaginatorImpl(
            items: $items,
            total: $merged->count(),
            perPage: self::PER_PAGE,
            currentPage: $page,
            options: ['path' => Paginator::resolveCurrentPath()],
        )->withQueryString();
    }

    /**
     * @return Collection<int, DealerDocListItemData>
     */
    private function dealerDocs(string $search): Collection
    {
        return DealerDoc::query()
            ->when($search !== '', static fn (Builder $query) => $query->where('title', 'like', "%{$search}%"))
            ->orderBy('title')
            ->get(self::DEALER_DOC_COLUMNS)
            ->map(static fn (DealerDoc $doc): DealerDocListItemData => DealerDocListItemData::fromDealerDoc($doc));
    }

    /**
     * @return Collection<int, DealerDocListItemData>
     */
    private function sharedDocuments(string $search): Collection
    {
        return tenancy()->central(static fn (): Collection => SharedDocument::query()
            ->when($search !== '', static fn (Builder $query) => $query->where('title', 'like', "%{$search}%"))
            ->orderBy('title')
            ->get(self::SHARED_DOCUMENT_COLUMNS)
            ->map(static fn (SharedDocument $doc): DealerDocListItemData => DealerDocListItemData::fromSharedDocument($doc)));
    }
}
