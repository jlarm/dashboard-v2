<?php

namespace App\Observers;

use App\Models\CourseResults;
use Illuminate\Support\Facades\Cache;

class CourseResultsObserver
{
    /**
     * Handle the CourseResults "created" event.
     */
    public function created(CourseResults $courseResults): void
    {
        // Clear the specific user's completed courses cache
        Cache::store('redis')->forget('completed_courses_'.$courseResults->user_id);
    }

    /**
     * Handle the CourseResults "updated" event.
     */
    public function updated(CourseResults $courseResults): void
    {
        // Clear the specific user's completed courses cache
        Cache::store('redis')->forget('completed_courses_'.$courseResults->user_id);
    }

    /**
     * Handle the CourseResults "deleted" event.
     */
    public function deleted(CourseResults $courseResults): void
    {
        //
    }

    /**
     * Handle the CourseResults "restored" event.
     */
    public function restored(CourseResults $courseResults): void
    {
        //
    }

    /**
     * Handle the CourseResults "force deleted" event.
     */
    public function forceDeleted(CourseResults $courseResults): void
    {
        //
    }
}
