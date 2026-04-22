<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Data;

final readonly class CourseQuizData
{
    /**
     * @param  array<int, array{question: ?string, answers: array<int, array<string, string>>, correctAnswer: ?string}>  $questions
     */
    public function __construct(
        public array $questions,
    ) {}
}
