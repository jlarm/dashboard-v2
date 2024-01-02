<?php

namespace App\Http\Controllers\Central\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\View\View;

class ShowController extends Controller
{
    public function __invoke(Course $course): View
    {
        return view('central.course.show', [
            'course' => $course,
        ]);
    }
}
