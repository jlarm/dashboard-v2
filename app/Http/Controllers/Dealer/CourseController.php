<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Course;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function show(Course $course): View
    {
        return view('dealer.course.show', [
            'course' => $course,
        ]);
    }

    public function quiz(Course $course): View
    {
        return view('dealer.course.quiz', [
            'course' => $course,
        ]);
    }

    public function edit(Course $course): View
    {
        return view('dealer.course.edit', [
            'course' => $course,
        ]);
    }
}
