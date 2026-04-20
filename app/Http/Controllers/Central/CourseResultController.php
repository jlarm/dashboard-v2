<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\Courses\Actions\StoreCourseResult;
use App\Http\Controllers\Controller;
use App\Http\Requests\Central\StoreQuizResultRequest;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;

class CourseResultController extends Controller
{
    public function store(
        StoreQuizResultRequest $request,
        Course $course,
        StoreCourseResult $storeCourseResult
    ): RedirectResponse {
        $this->authorize('view', $course);

        $submittedAnswers = Arr::flatten($request->only('question'));

        $storeCourseResult->execute($course, $submittedAnswers);

        return to_route('courses.index');
    }
}
