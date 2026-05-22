<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class GetOpenInvites
{
    private const int PER_PAGE = 25;

    /**
     * @param  array{search?: string, department_id?: int|null}  $filters
     * @return array{
     *     paginator: LengthAwarePaginator<int, Invite>,
     *     departments: list<array{id: int, name: string}>,
     *     multiple_stores: bool
     * }
     */
    public function handle(User $viewer, array $filters, int $page = 1): array
    {
        $baseQuery = $this->baseQuery($viewer, $filters);

        $paginator = (clone $baseQuery)
            ->with(['user:id,name'])
            ->paginate(perPage: self::PER_PAGE, page: $page);

        $departments = $this->departmentOptions($viewer);
        $multipleStores = app()->bound('multipleStoresExist') && (bool) resolve('multipleStoresExist');

        /** @var Collection<int, Invite> $invites */
        $invites = collect($paginator->items());
        $storeNameMap = $multipleStores ? $this->storeNameMap($invites) : collect();

        $paginator->setCollection(
            $invites
                ->map(fn (Invite $invite): array => $this->presentInvite($invite, $storeNameMap, $multipleStores))
                ->values(),
        );

        return [
            'paginator' => $paginator,
            'departments' => $departments,
            'multiple_stores' => $multipleStores,
        ];
    }

    /**
     * @return Builder<Invite>
     */
    public function buildScopedQuery(User $viewer): Builder
    {
        return $this->baseQuery($viewer, []);
    }

    /**
     * @param  array{search?: string, department_id?: int|null}  $filters
     * @return Builder<Invite>
     */
    private function baseQuery(User $viewer, array $filters): Builder
    {
        $query = Invite::query()
            ->whereNull('registered_at')->latest();

        $this->applyStoreFilter($query);
        $this->applyDepartmentScope($query, $viewer);

        if (($filters['department_id'] ?? null) !== null) {
            $query->where('department_id', (int) $filters['department_id']);
        }

        $search = mb_trim((string) ($filters['search'] ?? ''));
        if ($search !== '') {
            $query->where(function (Builder $query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    /**
     * @param  Builder<Invite>  $query
     */
    private function applyStoreFilter(Builder $query): void
    {
        if (! app()->bound('multipleStoresExist') || ! resolve('multipleStoresExist')) {
            return;
        }

        $storeIds = $this->resolveScopedStoreIds();

        if ($storeIds->isEmpty()) {
            $query->whereRaw('1 = 0');

            return;
        }

        $query->where(function (Builder $query) use ($storeIds): void {
            foreach ($storeIds as $storeId) {
                $query->orWhereJsonContains('stores', (string) $storeId)
                    ->orWhereJsonContains('stores', (int) $storeId);
            }
        });
    }

    /**
     * @param  Builder<Invite>  $query
     */
    private function applyDepartmentScope(Builder $query, User $viewer): void
    {
        if ($viewer->can('create-stores') || $viewer->department_id === null) {
            return;
        }

        $query->where('department_id', $viewer->department_id);
    }

    /**
     * @return Collection<int, int>
     */
    private function resolveScopedStoreIds(): Collection
    {
        if (app()->bound('scopedStoreIds')) {
            /** @var Collection<int, int> $scoped */
            $scoped = resolve('scopedStoreIds');
            $normalized = $scoped->map(static fn (int $id): int => $id)->values();

            if ($normalized->isNotEmpty()) {
                return $normalized;
            }
        }

        return collect();
    }

    /**
     * @return list<array{id: int, name: string}>
     */
    private function departmentOptions(User $viewer): array
    {
        $query = Department::query()->orderBy('name');

        if (! $viewer->can('create-stores') && $viewer->department_id !== null) {
            $query->where('id', $viewer->department_id);
        }

        return array_values(
            $query
                ->get(['id', 'name'])
                ->map(static fn (Department $department): array => [
                    'id' => (int) $department->id,
                    'name' => (string) $department->name,
                ])
                ->all(),
        );
    }

    /**
     * @param  Collection<int, Invite>  $invites
     * @return Collection<int, string>
     */
    private function storeNameMap(Collection $invites): Collection
    {
        $ids = $invites
            ->flatMap(fn (Invite $invite): array => $this->normalizeInviteStoreIds($invite->stores ?? []))
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return collect();
        }

        return Store::query()
            ->whereIn('id', $ids)
            ->pluck('name', 'id')
            ->map(static fn (mixed $name): string => (string) $name);
    }

    /**
     * @param  Collection<int, string>  $storeNameMap
     * @return array<string, mixed>
     */
    private function presentInvite(Invite $invite, Collection $storeNameMap, bool $includeStores): array
    {
        $storeNames = $includeStores
            ? array_values(array_filter(array_map(
                static fn (int $id): ?string => $storeNameMap->get($id),
                $this->normalizeInviteStoreIds($invite->stores ?? []),
            )))
            : [];

        return [
            'id' => (int) $invite->id,
            'name' => (string) $invite->name,
            'email' => (string) $invite->email,
            'department_id' => $invite->department_id === null ? null : (int) $invite->department_id,
            'store_names' => $storeNames,
            'last_sent_at' => $invite->updated_at?->toIso8601String(),
            'last_sent_at_formatted' => $invite->updated_at?->format('M j, Y'),
            'sent_by' => $invite->user?->name,
        ];
    }

    /**
     * @param  array<int|string, mixed>  $stores
     * @return list<int>
     */
    private function normalizeInviteStoreIds(array $stores): array
    {
        return array_values(
            collect(Arr::flatten($stores))
                ->map(static fn (mixed $storeId): int => (int) $storeId)
                ->filter(static fn (int $storeId): bool => $storeId > 0)
                ->unique()
                ->all(),
        );
    }
}
