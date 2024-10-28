<?php

namespace App\Traits;

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

trait HasCourses
{
    use EmployeeCourses;


    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(CourseResults::class);
    }
}
