<?php

declare(strict_types=1);

namespace App\Domain\Tenant\IndividualAudits\Queries;

use App\Models\IndividualQuestions;

class ListIndividualQuestions
{
    /**
     * Loads the 40 deal-jacket review questions (id 1-40) from the central
     * tenancy. Returns a flat array shape friendly for the Vue page:
     * [{id, question, kind: 'finance' | 'condition' | 'yes_no'}, ...].
     *
     * @return array<int, array{id: int, question: string, kind: string}>
     */
    public function handle(): array
    {
        return tenancy()->central(static fn (): array => IndividualQuestions::query()
            ->orderBy('id')
            ->get(['id', 'question'])
            ->map(static fn (IndividualQuestions $q): array => [
                'id' => (int) $q->id,
                'question' => (string) $q->question,
                'kind' => match ((int) $q->id) {
                    1 => 'finance',
                    2 => 'condition',
                    default => 'yes_no',
                },
            ])
            ->all()
        );
    }
}
