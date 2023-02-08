<?php

namespace App\Http\Controllers\Dealer;

use App\Exports\UserCourseResultsExport;
use App\Http\Controllers\Controller;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class CourseResultsController extends Controller
{
    public function export()
    {
        return Excel::download(new UserCourseResultsExport, 'users.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $count = count($course['questions']);
        $questions = collect($course['questions']);
        $correctAnswers = $questions->pluck('correctAnswer')->toArray();
        $submittedAnswers = Arr::flatten($request->only('question'));
        $score = 0;

        for ($i = 0; $i < $count; $i++) {
            if ($correctAnswers[$i] == $submittedAnswers[$i]) {
                $score++;
            }
        }

        // generate score
        $score = ($score / $count) * 100;

        // check if passed
        $passed = $score >= 70 ? true : false;

        CourseResults::create([
            'percentage' => $score,
            'passed' => $passed,
            'course_id' => $course->id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('dealer.courses.index');
    }
}
