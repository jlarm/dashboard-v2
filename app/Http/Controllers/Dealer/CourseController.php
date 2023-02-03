<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Course;

class CourseController extends Controller
{
    public function show(Course $course)
    {
        return view('dealer.course.show', [
            'course' => $course,
        ]);
    }

    public function quiz(Course $course)
    {
        return view('dealer.course.quiz', [
            'course' => $course,
        ]);
    }
}
