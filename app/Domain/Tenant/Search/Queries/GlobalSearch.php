<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Search\Queries;

use App\Domain\Tenant\Search\Data\SearchResultData;
use App\Domain\Tenant\User\Data\EmployeeFiltersData;
use App\Domain\Tenant\User\Queries\GetEmployees;
use App\Models\Dealer\Course;
use App\Models\Dealer\Vendor;
use App\Models\DealerDoc;
use App\Models\Sds;
use App\Models\SharedDocument;
use App\Models\User;
use App\Services\StoreScopeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Fans a single search term across every tenant-visible resource.
 *
 * Each resource block reuses the same access scoping its index page
 * applies, so the palette can never surface a record the viewer could
 * not already reach through normal navigation (department, assigned
 * stores, and role rules all carry over).
 */
class GlobalSearch
{
    private const int MIN_TERM_LENGTH = 2;

    private const int PER_GROUP = 5;

    public function __construct(
        private readonly GetEmployees $employees,
        private readonly StoreScopeService $storeScopeService,
    ) {}

    /**
     * @return list<array{key: string, label: string, items: list<array<string, mixed>>}>
     */
    public function handle(User $viewer, string $term): array
    {
        $term = mb_trim($term);

        if (mb_strlen($term) < self::MIN_TERM_LENGTH) {
            return [];
        }

        $groups = [
            ['key' => 'employees', 'label' => 'Employees', 'results' => $this->employeeResults($viewer, $term)],
            ['key' => 'vendors', 'label' => 'Vendors', 'results' => $this->vendorResults($viewer, $term)],
            ['key' => 'documents', 'label' => 'Documents', 'results' => $this->documentResults($term)],
            ['key' => 'sds', 'label' => 'Safety Data Sheets', 'results' => $this->sdsResults($term)],
            ['key' => 'courses', 'label' => 'Courses', 'results' => $this->courseResults($term)],
        ];

        $populated = [];

        foreach ($groups as $group) {
            if ($group['results'] === []) {
                continue;
            }

            $populated[] = [
                'key' => $group['key'],
                'label' => $group['label'],
                'items' => array_map(
                    static fn (SearchResultData $result): array => $result->toArray(),
                    $group['results'],
                ),
            ];
        }

        return $populated;
    }

    private static function vendorSubtitle(Vendor $vendor): string
    {
        $contactName = (string) $vendor->contact_name;

        if ($contactName !== '') {
            return $contactName;
        }

        $contactEmail = (string) $vendor->contact_email;

        return $contactEmail !== '' ? $contactEmail : 'Vendor';
    }

    /**
     * Reuses the employee index's scoped query, so department, assigned
     * store, and role exclusions are enforced exactly as on that page.
     *
     * @return list<SearchResultData>
     */
    private function employeeResults(User $viewer, string $term): array
    {
        return $this->employees
            ->buildScopedQuery($viewer, EmployeeFiltersData::empty())
            ->where(function (Builder $query) use ($term): void {
                $query->where('users.name', 'like', "%{$term}%")
                    ->orWhere('users.email', 'like', "%{$term}%");
            })
            ->limit(self::PER_GROUP)
            ->get()
            ->map(static fn (User $user): SearchResultData => new SearchResultData(
                type: 'employee',
                id: (string) $user->id,
                title: (string) $user->name,
                subtitle: (string) $user->email,
                url: $user->slug !== null
                    ? route('dealer.employees.show', $user->slug, false)
                    : route('dealer.employees.index', absolute: false),
            ))
            ->all();
    }

    /**
     * Mirrors the vendor index scoping: vendors in the viewer's accessible
     * stores plus store-less vendors.
     *
     * @return list<SearchResultData>
     */
    private function vendorResults(User $viewer, string $term): array
    {
        $scopedStoreIds = $this->storeScopeService->scopedStoreIds($viewer);

        return Vendor::query()
            ->where(function (Builder $query) use ($scopedStoreIds): void {
                if ($scopedStoreIds->isNotEmpty()) {
                    $query->whereIn('store_id', $scopedStoreIds);
                }

                $query->orWhereNull('store_id');
            })
            ->where(function (Builder $query) use ($term): void {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('contact_name', 'like', "%{$term}%")
                    ->orWhere('contact_email', 'like', "%{$term}%");
            })
            ->orderBy('name')
            ->limit(self::PER_GROUP)
            ->get(['id', 'name', 'contact_name', 'contact_email'])
            ->map(static fn (Vendor $vendor): SearchResultData => new SearchResultData(
                type: 'vendor',
                id: (string) $vendor->id,
                title: (string) $vendor->name,
                subtitle: self::vendorSubtitle($vendor),
                url: route('dealer.vendor.show', $vendor->id, false),
            ))
            ->all();
    }

    /**
     * Tenant documents and the shared central catalog, merged and sorted
     * together exactly as the documents index presents them.
     *
     * @return list<SearchResultData>
     */
    private function documentResults(string $term): array
    {
        $dealerDocs = DealerDoc::query()
            ->where('title', 'like', "%{$term}%")
            ->orderBy('title')
            ->limit(self::PER_GROUP)
            ->get(['id', 'title'])
            ->map(static fn (DealerDoc $doc): SearchResultData => new SearchResultData(
                type: 'document',
                id: 'dealer-'.$doc->id,
                title: (string) $doc->title,
                subtitle: 'Document',
                url: route('dealer.doc.index', ['search' => $doc->title], false),
            ))
            ->all();

        /** @var list<SearchResultData> $sharedDocs */
        $sharedDocs = tenancy()->central(static fn (): array => SharedDocument::query()
            ->where('title', 'like', "%{$term}%")
            ->orderBy('title')
            ->limit(self::PER_GROUP)
            ->get(['id', 'title'])
            ->map(static fn (SharedDocument $doc): SearchResultData => new SearchResultData(
                type: 'document',
                id: 'shared-'.$doc->id,
                title: (string) $doc->title,
                subtitle: 'Shared document',
                url: route('dealer.doc.index', ['search' => $doc->title], false),
            ))
            ->all());

        return collect([...$dealerDocs, ...$sharedDocs])
            ->sortBy(static fn (SearchResultData $result): string => Str::lower($result->title))
            ->take(self::PER_GROUP)
            ->values()
            ->all();
    }

    /**
     * The SDS catalog lives in the central database and is shared
     * dealer-wide; results link to the pre-filtered index.
     *
     * @return list<SearchResultData>
     */
    private function sdsResults(string $term): array
    {
        /** @var list<SearchResultData> $results */
        $results = tenancy()->central(static fn (): array => Sds::query()
            ->where(function (Builder $query) use ($term): void {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('manufacturer', 'like', "%{$term}%");
            })
            ->orderBy('name')
            ->limit(self::PER_GROUP)
            ->get(['id', 'name', 'manufacturer'])
            ->map(static fn (Sds $sds): SearchResultData => new SearchResultData(
                type: 'sds',
                id: (string) $sds->id,
                title: (string) $sds->name,
                subtitle: ((string) $sds->manufacturer) !== '' ? (string) $sds->manufacturer : 'Safety data sheet',
                url: route('dealer.sds.index', ['search' => $sds->name], false),
            ))
            ->values()
            ->all());

        return $results;
    }

    /**
     * @return list<SearchResultData>
     */
    private function courseResults(string $term): array
    {
        return Course::query()
            ->where('name', 'like', "%{$term}%")
            ->orderBy('name')
            ->limit(self::PER_GROUP)
            ->get(['id', 'name', 'slug'])
            ->map(static fn (Course $course): SearchResultData => new SearchResultData(
                type: 'course',
                id: (string) $course->id,
                title: (string) $course->name,
                subtitle: 'Course',
                url: route('dealer.courses.show', $course->slug, false),
            ))
            ->all();
    }
}
