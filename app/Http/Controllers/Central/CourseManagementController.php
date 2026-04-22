<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\Courses\Actions\BuildCourseEditData;
use App\Domain\Central\Courses\Actions\ImportCourses;
use App\Domain\Central\Courses\Actions\UpdateCourseQuiz;
use App\Domain\Central\Courses\Actions\UpdateCourseSettings;
use App\Domain\Central\Courses\Actions\UpdateCourseSlides;
use App\Domain\Central\Courses\Data\CourseQuizData;
use App\Domain\Central\Courses\Data\CourseSettingsData;
use App\Domain\Central\Courses\Data\CourseSlidesData;
use App\Domain\Central\Courses\Queries\SearchCoursesForManagement;
use App\Http\Controllers\Controller;
use App\Http\Requests\Central\CourseManagement\ImportCoursesRequest;
use App\Http\Requests\Central\CourseManagement\UpdateCourseQuizRequest;
use App\Http\Requests\Central\CourseManagement\UpdateCourseSettingsRequest;
use App\Http\Requests\Central\CourseManagement\UpdateCourseSlidesRequest;
use App\Http\Resources\Central\CourseManagement\CourseManagementIndexResource;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CourseManagementController extends Controller
{
    public function index(Request $request, SearchCoursesForManagement $query): Response
    {
        $this->authorize('manage', Course::class);

        return Inertia::render('central/course-management/Index', [
            'courses' => CourseManagementIndexResource::collection(
                $query->handle($request->string('search')->toString() ?: null)
            ),
            'filters' => $request->only(['search']),
        ]);
    }

    public function edit(Course $course, BuildCourseEditData $buildEditData): Response
    {
        $this->authorize('update', $course);

        return Inertia::render('central/course-management/Edit', $buildEditData->execute($course));
    }

    public function update(UpdateCourseSlidesRequest $request, Course $course, UpdateCourseSlides $action): RedirectResponse
    {
        $this->authorize('update', $course);

        $validated = $request->validated();

        $action->handle($course, new CourseSlidesData(
            name: $validated['name'],
            video_id: $validated['video_id'] ?? null,
            slides: $validated['slides'],
        ));

        return back()->with('flash.success', 'Course updated.');
    }

    public function updateQuiz(UpdateCourseQuizRequest $request, Course $course, UpdateCourseQuiz $action): RedirectResponse
    {
        $this->authorize('update', $course);

        $action->handle($course, new CourseQuizData(
            questions: $request->validated('questions') ?? [],
        ));

        return back()->with('flash.success', 'Course quiz updated.');
    }

    public function updateSettings(UpdateCourseSettingsRequest $request, Course $course, UpdateCourseSettings $action): RedirectResponse
    {
        $this->authorize('update', $course);

        $validated = $request->validated();

        $action->handle($course, new CourseSettingsData(
            department_ids: $validated['department_ids'] ?? [],
            role_ids: $validated['role_ids'] ?? [],
            states_required: array_values($validated['states_required'] ?? []),
            replaces_course_slugs: array_values($validated['replaces_course_slugs'] ?? []),
        ));

        return back()->with('flash.success', 'Course settings updated.');
    }

    public function import(ImportCoursesRequest $request, ImportCourses $action): RedirectResponse
    {
        $this->authorize('import', Course::class);

        $stats = $action->handle($request->file('file'));

        return to_route('course-management.index')
            ->with('flash.success', "Imported {$stats['created']} course(s), updated {$stats['updated']} course(s).");
    }
}
