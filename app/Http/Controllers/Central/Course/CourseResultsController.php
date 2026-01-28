<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseResults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CourseResultsController extends Controller
{
    public function __invoke(Request $request, Course $course): RedirectResponse
    {
        $count = count($course['questions']);
        $questions = collect($course['questions']);
        $correctAnswers = $questions->pluck('correctAnswer')->toArray();
        $submittedAnswers = Arr::flatten($request->only('question'));
        $score = 0;

        for ($i = 0; $i < $count; $i++) {
            if ($correctAnswers[$i] === $submittedAnswers[$i]) {
                $score++;
            }
        }

        // generate score
        $score = ($score / $count) * 100;

        // check if passed
        $passed = $score >= 70;

        CourseResults::create([
            'percentage' => $score,
            'passed' => $passed,
            'course_id' => $course->id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('courses.index');
    }
}
