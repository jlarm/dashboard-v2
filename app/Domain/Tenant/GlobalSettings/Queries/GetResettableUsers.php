<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Queries;

use App\Domain\Tenant\GlobalSettings\Data\ResettableUserData;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetResettableUsers
{
    /**
     * @var array<int, string>
     */
    private const array SELECT_COLUMNS = ['id', 'name', 'email', 'department_id'];

    /**
     * @return list<ResettableUserData>
     */
    public function handle(string $search = ''): array
    {
        return $this->baseQuery($search)
            ->get()
            ->map(static fn (User $user): ResettableUserData => ResettableUserData::fromModel($user))
            ->values()
            ->all();
    }

    /**
     * @return Collection<int, int>
     */
    public function allUserIds(): Collection
    {
        return CourseResults::query()
            ->distinct()
            ->pluck('user_id')
            ->map(static fn ($userId): int => (int) $userId)
            ->filter()
            ->unique()
            ->values();
    }

    private function baseQuery(string $search): Builder
    {
        $searchTerm = mb_trim($search);

        return User::query()
            ->withoutSuperAdminsAndConsultants()
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
                        ->orWhere('email', 'like', $like)
                        ->orWhereHas('stores', static function (Builder $storeQuery) use ($like): void {
                            $storeQuery->where('name', 'like', $like);
                        });
                });
            })
            ->orderBy('name');
    }
}
