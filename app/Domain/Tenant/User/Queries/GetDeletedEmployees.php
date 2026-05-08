<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class GetDeletedEmployees
{
    private const int PER_PAGE = 15;

    /**
     * @param  array{search?: string}  $filters
     */
    public function handle(User $viewer, array $filters, int $page = 1): LengthAwarePaginator
    {
        $paginator = $this->baseQuery($filters)
            ->with('department:id,name')
            ->paginate(perPage: self::PER_PAGE, page: $page);

        /** @var EloquentCollection<int, User> $users */
        $users = collect($paginator->items());

        $paginator->setCollection(
            $users->map(fn (User $user): array => $this->present($user))->values(), // @phpstan-ignore argument.type
        );

        return $paginator;
    }

    /**
     * @param  array{search?: string}  $filters
     */
    private function baseQuery(array $filters): Builder
    {
        $query = User::query()
            ->onlyTrashed()
            ->orderByDesc('deleted_at')
            ->orderByDesc('id');

        $this->applyStoreScope($query);

        $search = mb_trim((string) ($filters['search'] ?? ''));
        if ($search !== '') {
            $query->where(function (Builder $query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    private function applyStoreScope(Builder $query): void
    {
        if (! app()->bound('multipleStoresExist') || ! resolve('multipleStoresExist')) {
            return;
        }

        /** @var Collection<int, int> $storeIds */
        $storeIds = app()->bound('scopedStoreIds') ? resolve('scopedStoreIds') : collect();

        if ($storeIds->isEmpty()) {
            $query->whereRaw('1 = 0');

            return;
        }

        $query->whereHas('stores', function (Builder $query) use ($storeIds): void {
            $query->whereIn('stores.id', $storeIds);
        });
    }

    /**
     * @return array<string, mixed>
     */
    private function present(User $user): array
    {
        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'department_name' => $user->department?->name,
            'deleted_at' => $user->deleted_at?->toIso8601String(),
            'deleted_at_formatted' => $user->deleted_at?->format('M j, Y'),
        ];
    }
}
