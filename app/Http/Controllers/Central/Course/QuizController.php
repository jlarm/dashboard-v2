<?php

namespace App\Http\Controllers\Central\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;

class QuizController extends Controller
{
    public function __invoke(Course $course)
    {
        return view('central.course.quiz', [
            'course' => $course,
        ]);
    }
}
