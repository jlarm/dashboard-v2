<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\DealJackets;

use Illuminate\Foundation\Http\FormRequest;

class SaveDealJacketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'audit_date' => ['required', 'date'],
            'date_of_deal_jacket' => ['required', 'date'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_deal_number' => ['required', 'string', 'max:255'],
            'finance_manager' => ['required', 'string'],
            'mileage' => ['required', 'string', 'max:50'],
            'purchase_type' => ['required', 'string', 'max:50'],
            'vehicle_type' => ['required', 'string', 'max:50'],
            'responses' => ['required', 'array', 'min:1'],
            'responses.*.statement' => ['required', 'string'],
            'responses.*.answer' => ['required', 'in:yes,no,na'],
            'responses.*.high_risk' => ['nullable', 'boolean'],
            'responses.*.comment' => ['nullable', 'string'],
            'question_weights' => ['required', 'array'],
            'question_weights.*' => ['integer', 'min:1'],
        ];
    }

    /**
     * @return array{
     *   audit_date: string,
     *   date_of_deal_jacket: string,
     *   customer_name: string,
     *   customer_deal_number: string,
     *   user_id: ?int,
     *   mileage: string,
     *   purchase_type: string,
     *   vehicle_type: string,
     *   responses: array<int, array{statement: string, answer: ?string, high_risk: bool, comment: ?string}>,
     *   question_weights: array<int, int>,
     * }
     */
    public function toData(): array
    {
        /** @var array<string, mixed> $validated */
        $validated = $this->validated();

        $financeManager = (string) $validated['finance_manager'];
        $userId = $financeManager === 'house' ? null : (int) $financeManager;

        $responses = array_values(array_map(static fn (array $r): array => [
            'statement' => (string) $r['statement'],
            'answer' => isset($r['answer']) ? (string) $r['answer'] : null,
            'high_risk' => (bool) ($r['high_risk'] ?? false),
            'comment' => isset($r['comment']) ? (string) $r['comment'] : null,
        ], (array) $validated['responses']));

        $weights = array_map(static fn (mixed $w): int => (int) $w, (array) $validated['question_weights']);

        return [
            'audit_date' => (string) $validated['audit_date'],
            'date_of_deal_jacket' => (string) $validated['date_of_deal_jacket'],
            'customer_name' => (string) $validated['customer_name'],
            'customer_deal_number' => (string) $validated['customer_deal_number'],
            'user_id' => $userId,
            'mileage' => (string) $validated['mileage'],
            'purchase_type' => (string) $validated['purchase_type'],
            'vehicle_type' => (string) $validated['vehicle_type'],
            'responses' => $responses,
            'question_weights' => $weights,
        ];
    }
}
