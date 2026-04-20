<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Actions;

use App\Models\Course;
use App\Models\CourseResults;

class StoreCourseResult
{
    public function execute(Course $course, array $submittedAnswers): CourseResults
    {
        $questions = collect($course->questions);
        $correctAnswers = $questions->pluck('correctAnswer')->toArray();
        $count = $questions->count();

        $score = 0;

        for ($i = 0; $i < $count; $i++) {
            if (($correctAnswers[$i] ?? null) === ($submittedAnswers[$i] ?? null)) {
                $score++;
            }
        }

        $percentage = $count > 0 ? (int) round(($score / $count) * 100) : 0;

        return CourseResults::query()->create([
            'percentage' => $percentage,
            'passed' => $percentage >= 70,
            'course_id' => $course->id,
            'user_id' => auth()->id(),
        ]);
    }
}
