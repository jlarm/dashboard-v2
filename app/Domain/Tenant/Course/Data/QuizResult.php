<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Data;

class QuizResult
{
    /**
     * @param  list<array{question: string, incorrect_answer_key: string, incorrect_answer: string}>  $incorrectQuestions
     */
    public function __construct(
        public readonly float $score,
        public readonly bool $passed,
        public readonly array $incorrectQuestions,
    ) {}
}
