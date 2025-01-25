<?php

namespace App\Models\Dealer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class Course extends Model
{
    use HasRoles, LogsActivity;

    protected $fillable = [
        'department_id',
        'slug',
        'name',
        'slides',
        'questions',
        'years_expires',
    ];

    protected $casts = [
        'slides' => 'array',
        'questions' => 'array',
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

    public function getDepartments()
    {
        return $this->departments->pluck('id')->toArray();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function lastResult(): BelongsTo
    {
        return $this->belongsTo(CourseResults::class);
    }

    public function scopeWithLastResult($query): void
    {
        $query->addSelect(['last_result_id' => CourseResults::select('id')
            ->whereColumn('course_id', 'courses.id')
            ->latest()
            ->take(1)
        ])->with('lastResult');
    }
}
