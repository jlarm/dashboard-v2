<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Actions;

use App\Domain\Tenant\Course\Data\QuizResult;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;

class SubmitCourseQuiz
{
    private const int PASS_THRESHOLD = 70;

    /**
     * @param  array<int, string>  $submittedAnswers  Keyed by 1-indexed question number → answer key
     */
    public function handle(Course $course, User $user, array $submittedAnswers): QuizResult
    {
        $questions = collect($course->questions ?? [])->values();
        $count = $questions->count();
        $score = 0;
        $incorrectQuestions = [];

        foreach ($questions as $i => $question) {
            $answers = $question['answers'][0] ?? [];
            $correctKey = (string) ($question['correctAnswer'] ?? '');
            $submittedKey = (string) ($submittedAnswers[$i + 1] ?? '');

            if ($correctKey === $submittedKey) {
                $score++;

                continue;
            }

            $incorrectQuestions[] = [
                'question' => __((string) ($question['question'] ?? '')),
                'incorrect_answer_key' => $submittedKey,
                'incorrect_answer' => __((string) ($answers[$submittedKey] ?? '')),
            ];
        }

        $percentage = $count > 0 ? ($score / $count) * 100 : 0.0;
        $passed = $percentage >= self::PASS_THRESHOLD;

        CourseResults::query()->create([
            'percentage' => $percentage,
            'passed' => $passed,
            'course_id' => $course->id,
            'user_id' => $user->id,
        ]);

        return new QuizResult(
            score: $percentage,
            passed: $passed,
            incorrectQuestions: $incorrectQuestions,
        );
    }
}
