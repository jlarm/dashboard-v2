<?php

declare(strict_types=1);

namespace App\Queries\Feeds;

use App\Models\Dealer\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final readonly class CoursesFeed
{
    private readonly Collection $roles;
    private readonly Collection $userStates;

    public function __construct(
        private readonly User $user,
    ) {
        $this->user->load(['roles', 'stores', 'department']);
        $this->roles = $this->user->roles->pluck('id');
        $this->userStates = $this->user->stores->pluck('state');
    }

    public function builder(): Builder
    {
        return Course::query()
            ->select(['id', 'name', 'slug', 'years_expires'])
            ->withLastResult()
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('optional', false)
                        ->doesntHave('departments')
                        ->doesntHave('roles');

                    if (!$this->isCaliforniaUser()) {
                        $q->where('slug', '!=', 'sexual-harassment-training-in-california');
                    }
                })
                    ->orWhereHas('users', function ($q) {
                        $q->where('users.id', $this->user->id);
                    })
                    ->orWhere(function ($q) {
                        $q->whereHas('departments', function ($dq) {
                            $dq->where('departments.id', $this->user->department_id);
                        })->whereHas('roles', function ($rq) {
                            $rq->whereIn('roles.id', $this->roles);
                        });
                    })
                    ->orWhere(function ($q) {
                        $q->whereHas('roles', function ($rq) {
                            $rq->whereIn('roles.id', $this->roles);
                        })->doesntHave('departments');
                    });
            });
    }

    private function isCaliforniaUser(): bool
    {
        return $this->userStates->contains('California');
    }
}
