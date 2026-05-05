<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;

/**
 * @property-read Pivot|null $pivot
 * @property-read CourseResults|null $lastResult
 */
class Course extends Model
{
    use LogsActivity, SoftDeletes;

    #[Override]
    protected $fillable = [
        'department_id',
        'slug',
        'name',
        'slides',
        'questions',
        'optional',
        'years_expires',
        'video_id',
        'states_required',
        'replaces_course_slugs',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(CourseResults::class);
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }

    public function getDepartments(): array
    {
        return $this->departments->pluck('id')->toArray();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'course_role');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function lastResult(): BelongsTo
    {
        return $this->belongsTo(CourseResults::class);
    }

    protected function scopeWithLastResult($query, $userId): void
    {
        $query->addSelect(['last_result_id' => CourseResults::query()->select('id')
            ->whereColumn('course_id', 'courses.id')
            ->where('user_id', $userId)
            ->latest()
            ->take(1),
        ])->with('lastResult');
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'slides' => 'array',
            'questions' => 'array',
            'optional' => 'boolean',
            'states_required' => 'array',
            'replaces_course_slugs' => 'array',
        ];
    }
}
