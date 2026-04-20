<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\Courses\Actions\BuildCourseShowData;
use App\Domain\Central\Courses\Queries\GetCourses;
use App\Http\Controllers\Controller;
use App\Http\Resources\Central\CourseIndexResource;
use App\Http\Resources\Central\CourseShowResource;
use App\Models\Course;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Course::class, 'course');
    }

    public function index(GetCourses $courses): Response
    {
        return Inertia::render('central/course/Index', [
            'courses' => CourseIndexResource::collection(
                $courses->handle()
            ),
        ]);
    }

    public function show(Course $course, BuildCourseShowData $buildCourseShowData): Response
    {
        return Inertia::render('central/course/Show', [
            'course' => new CourseShowResource($course)->resolve(),
            ...$buildCourseShowData->execute($course),
        ]);
    }

    public function quiz(Course $course): Response
    {
        $this->authorize('view', $course);

        return Inertia::render('central/course/Quiz', [
            'course' => new CourseShowResource($course)->resolve(),
            'questions' => $course->questions ?? [],
        ]);
    }
}
