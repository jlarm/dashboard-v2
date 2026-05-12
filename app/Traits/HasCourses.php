<?php

declare(strict_types=1);

namespace App\Traits;

use App\Domain\Tenant\Course\DotCertificate;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use App\Services\UserCourseService;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin User
 *
 * @property int $total_user_courses
 */
trait HasCourses
{
    /**
     * @var list<int>|null
     */
    private ?array $userCourses = null;

    /**
     * Clear the cached user courses data.
     * Call this method after modifying course results to refresh the count.
     */
    public function clearCourseCache(): void
    {
        $this->userCourses = null;

        resolve(UserCourseService::class)->clearCacheForUser($this->id);

        if (isset($this->attributes['total_completed_courses'])) {
            unset($this->attributes['total_completed_courses']);
        }
        if (isset($this->attributes['total_user_courses'])) {
            unset($this->attributes['total_user_courses']);
        }
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)
            ->withPivot(['type', 'assigned_by']);
    }

    public function results(): HasMany
    {
        return $this->hasMany(CourseResults::class);
    }

    protected function getTotalCompletedCoursesAttribute(): int
    {
        $userCourseIds = $this->totalUserCourses();
        $oneYearAgo = now()->subYear();
        $threeYearsAgo = now()->subYears(3);
        $hazmatCourseIds = DotCertificate::HAZMAT_COURSE_IDS;

        if ($this->relationLoaded('results')) {
            return $this->results
                ->whereIn('course_id', $userCourseIds)
                ->where('passed', true)
                ->filter(fn (CourseResults $result): bool => $result->created_at >= $oneYearAgo // @phpstan-ignore argument.type
                    || (in_array($result->course_id, $hazmatCourseIds, true) && $result->created_at >= $threeYearsAgo))
                ->unique('course_id')
                ->count();
        }

        return CourseResults::query()
            ->distinct()
            ->where('user_id', $this->id)
            ->whereIn('course_id', $userCourseIds)
            ->where(function ($query) use ($oneYearAgo, $threeYearsAgo, $hazmatCourseIds): void {
                $query->where('created_at', '>=', $oneYearAgo)
                    ->orWhere(function ($query) use ($threeYearsAgo, $hazmatCourseIds): void {
                        $query->whereIn('course_id', $hazmatCourseIds)
                            ->where('created_at', '>=', $threeYearsAgo);
                    });
            })
            ->where('passed', true)
            ->select('course_id')
            ->count('course_id');
    }

    protected function getTotalUserCoursesAttribute(): int
    {
        return count($this->totalUserCourses());
    }

    protected function getUserHasNotCompletedCoursesAttribute(): bool
    {
        return $this->total_completed_courses !== $this->total_user_courses;
    }

    /**
     * @return list<int>
     */
    private function totalUserCourses(): array
    {
        if ($this->userCourses === null) {
            if (! $this->relationLoaded('roles')) {
                $this->load('roles');
            }

            $this->userCourses = resolve(UserCourseService::class)->getCourseIds($this);
        }

        return $this->userCourses;
    }
}
