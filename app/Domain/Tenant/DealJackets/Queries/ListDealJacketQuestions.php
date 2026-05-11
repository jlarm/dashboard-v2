<?php

declare(strict_types=1);

namespace App\Domain\Tenant\DealJackets\Queries;

use App\Models\DealJacketQuestion;

class ListDealJacketQuestions
{
    /**
     * @return array<int, array{id: int, question: string, statement: string, categories: array<int, string>, weight: int}>
     */
    public function handle(): array
    {
        return tenancy()->central(static fn (): array => DealJacketQuestion::query()
            ->orderBy('id')
            ->get()
            ->map(static fn (DealJacketQuestion $q): array => [
                'id' => (int) $q->id,
                'question' => (string) $q->question,
                'statement' => (string) $q->statement,
                'categories' => (array) ($q->categories ?? []),
                'weight' => (int) ($q->weight ?? 1),
            ])
            ->all()
        );
    }
}
