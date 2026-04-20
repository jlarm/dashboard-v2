<?php

declare(strict_types=1);

namespace App\Models\Tenant;

use App\Models\Abstracts\AbstractCourse;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Course extends AbstractCourse
{
    use LogsActivity;

    public const string CALIFORNIA_TRAINING_SLUG = 'sexual-harassment-training-in-california';

    public function getDepartments()
    {
        return $this->departments->pluck('id')->toArray();
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
}
