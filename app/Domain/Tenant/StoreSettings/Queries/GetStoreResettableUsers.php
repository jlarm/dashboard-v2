<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Queries;

use App\Domain\Tenant\GlobalSettings\Data\ResettableUserData;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetStoreResettableUsers
{
    /**
     * @var array<int, string>
     */
    private const array SELECT_COLUMNS = ['id', 'name', 'email', 'department_id'];

    /**
     * @return list<ResettableUserData>
     */
    public function handle(Store $store, string $search = ''): array
    {
        return $this->baseQuery($store, $search)
            ->get()
            ->map(static fn (User $user): ResettableUserData => ResettableUserData::fromModel($user))
            ->values()
            ->all();
    }

    /**
     * @return Collection<int, int>
     */
    public function userIdsForStore(Store $store): Collection
    {
        $storeUserIds = $store->users()->pluck('users.id')->map(static fn (mixed $id): int => (int) $id);

        /** @phpstan-ignore return.type */
        return CourseResults::query()
            ->whereIn('user_id', $storeUserIds)
            ->distinct()
            ->pluck('user_id')
            ->map(static fn (mixed $userId): int => (int) $userId)
            ->filter()
            ->unique()
            ->values();
    }

    /**
     * @return Builder<User>
     */
    private function baseQuery(Store $store, string $search): Builder
    {
        $searchTerm = mb_trim($search);

        return User::query()
            ->withoutSuperAdminsAndConsultants()
            ->whereHas('stores', static fn (Builder $query) => $query->whereKey($store->id))
            ->with([
                'roles:id,name',
                'stores:id,name,state',
                'courseOverrides:user_id,course_id,type',
                'results:id,user_id,course_id,passed,created_at',
            ])
            ->withCount('results')
            ->select(self::SELECT_COLUMNS)
            ->when($searchTerm !== '', static function (Builder $query) use ($searchTerm): void {
                $like = '%'.$searchTerm.'%';

                $query->where(static function (Builder $inner) use ($like): void {
                    $inner->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like);
                });
            })
            ->orderBy('name');
    }
}
