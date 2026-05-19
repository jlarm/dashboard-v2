<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Queries;

use App\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\Relation;

class GetCourses
{
    public function handle(): LengthAwarePaginator
    {
        return Course::query()
            ->with(['latestUserResult' => fn (Relation $query) => $query->select('course_results.id', 'course_results.course_id', 'passed', 'percentage', 'created_at')])
            ->orderBy('name')
            ->paginate(24)
            ->withQueryString();
    }
}
