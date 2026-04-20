<?php

declare(strict_types=1);

namespace App\Models\Abstracts;

use App\Enums\CourseStatus;
use App\Models\CourseResults;
use App\Models\Department;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Override;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property array $slides
 * @property array $questions
 * @property bool $optional
 * @property string $video_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
abstract class AbstractCourse extends Model
{
    use HasFactory, HasRoles;

    final public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    final public function results(): HasMany
    {
        return $this->hasMany(CourseResults::class);
    }

    final public function latestUserResult(): HasOne
    {
        return $this->hasOne(CourseResults::class)->ofMany(
            ['created_at' => 'max'],
            fn (Builder $query) => $query->where('user_id', auth()->id())
        );
    }

    final public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }

    final public function status(): CourseStatus
    {
        if (! $this->latestUserResult) {
            return CourseStatus::NotStarted;
        }

        return $this->latestUserResult->passed
            ? CourseStatus::Passed
            : CourseStatus::Failed;
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'slug' => 'string',
            'name' => 'string',
            'slides' => 'array',
            'questions' => 'array',
            'optional' => 'boolean',
            'video_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
