<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Course\Actions\DispatchDotCertificate;
use App\Domain\Tenant\Course\Actions\MarkCourseVideoComplete;
use App\Domain\Tenant\Course\Actions\ResolveReplacementCourse;
use App\Domain\Tenant\Course\Actions\SubmitCourseQuiz;
use App\Domain\Tenant\Course\DotCertificate;
use App\Domain\Tenant\Course\Queries\CanIssueDotCertificate;
use App\Domain\Tenant\Course\Queries\GetUserCourseList;
use App\Domain\Tenant\Course\Queries\ListAllCoursesForAdmin;
use App\Domain\Tenant\Course\Queries\LoadCoursePlayer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Courses\SubmitQuizRequest;
use App\Models\Dealer\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use RuntimeException;

class CourseController extends Controller
{
    public function index(
        Request $request,
        GetUserCourseList $listCourses,
        CanIssueDotCertificate $canIssueDotCert,
    ): InertiaResponse {
        $user = $this->requireUser($request);

        return Inertia::render('dealer/courses/Index', [
            'courses' => $listCourses->handle($user)
                ->map(static fn (\App\Domain\Tenant\Course\Data\UserCourseListItem $item): array => $item->toArray())
                ->all(),
            'can_issue_dot_certificate' => $canIssueDotCert->handle($user),
        ]);
    }

    public function all(Request $request, ListAllCoursesForAdmin $listAll): InertiaResponse
    {
        return Inertia::render('dealer/courses/All', [
            'courses' => $listAll->handle($this->requireUser($request))
                ->map(static fn (\App\Domain\Tenant\Course\Data\UserCourseListItem $item): array => $item->toArray())
                ->all(),
        ]);
    }

    public function show(
        Request $request,
        Course $course,
        ResolveReplacementCourse $resolve,
        LoadCoursePlayer $loadPlayer,
    ): InertiaResponse|RedirectResponse {
        $user = $this->requireUser($request);

        $replacement = $resolve->handle($course, $user);
        if ($replacement instanceof Course) {
            return to_route('dealer.courses.show', $replacement);
        }

        return Inertia::render('dealer/courses/Show', $loadPlayer->handle($course, $user)->toArray());
    }

    public function quiz(
        Request $request,
        Course $course,
        ResolveReplacementCourse $resolve,
    ): InertiaResponse|RedirectResponse {
        $user = $this->requireUser($request);

        $replacement = $resolve->handle($course, $user);
        if ($replacement instanceof Course) {
            return to_route('dealer.courses.quiz', $replacement);
        }

        return Inertia::render('dealer/courses/Quiz', [
            'course' => [
                'id' => (int) $course->id,
                'name' => (string) $course->name,
                'slug' => (string) $course->slug,
                'questions' => array_values((array) ($course->questions ?? [])),
            ],
        ]);
    }

    public function submitQuiz(
        SubmitQuizRequest $request,
        Course $course,
        SubmitCourseQuiz $submit,
        DispatchDotCertificate $dispatchCert,
    ): RedirectResponse {
        $user = $this->requireUser($request);
        $result = $submit->handle($course, $user, $request->answers());

        $dotCertDispatched = $result->passed && $course->slug === DotCertificate::COURSE_SLUG && $dispatchCert->handle($user, (string) tenant('name'), now()->format('F d, Y'));

        return to_route('dealer.courses.index')->with('quiz', [
            'percentage' => round($result->score),
            'passed' => $result->passed,
            'course_name' => $course->name,
            'course_url' => route('dealer.courses.show', $course),
            'incorrect_questions' => $result->incorrectQuestions,
            'dot_certificate_queued' => $dotCertDispatched,
        ]);
    }

    public function markVideoComplete(
        Request $request,
        Course $course,
        MarkCourseVideoComplete $mark,
    ): RedirectResponse {
        $mark->handle($course, $this->requireUser($request));

        return back();
    }

    public function issueDotCertificate(
        Request $request,
        DispatchDotCertificate $dispatch,
    ): RedirectResponse {
        $this->authorize('selfIssueDotCertificate', User::class);

        $dispatched = $dispatch->handle($this->requireUser($request), (string) tenant('name'), now()->format('F d, Y'));

        return back()->with(
            $dispatched ? 'success' : 'error',
            $dispatched
                ? 'Your certificate is being generated and will be available in your profile shortly.'
                : 'You are not eligible for a certificate right now.',
        );
    }

    private function requireUser(Request $request): User
    {
        $user = $request->user();
        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        return $user;
    }
}
