<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\IndividualAudit;

class DealJacketPdfTestController extends Controller
{
    public array $array = [];
    public $managers;
    public $question;
    public $dealJackets;
    public $audits;
    public $count;
    public $managerIssueCount = [];
    public $results = [];
    public $totals = [];
    public $grandTotal;

    public function __invoke()
    {
        $this->dealJackets = IndividualAudit::query()
            ->with('user')
            ->where('id', 9)
            ->orWhere('parent_id', 9)
            ->get();

        $this->count = $this->dealJackets
            ->groupBy(fn ($item) => $item->manager->name)
            ->map(function ($item) {
                $this->array = [];
                $item->each(function ($item, $key) {
                    foreach ($item->getAttributes() as $key => $value) {
                        if (
                            $key !== 'id' &&
                            $key !== 'parent_id' &&
                            $key !== 'user_id' &&
                            $key !== 'store_id' &&
                            $key !== 'manager_id' &&
                            $key !== 'mileage' &&
                            $key !== 'customer_number' &&
                            $key !== 'rating' &&
                            $key !== 'individual_q1_answer' &&
                            $key !== 'individual_q2_answer'
                        ) {
                            if ($value === 2) {
                                $this->array[] = $value;
                            }
                        }
                    }
                });

                return count($this->array);
            });

        $this->managerIssueCount = $this->dealJackets
            ->groupBy(fn ($item) => $item->manager->name)
            ->map(function ($item) {
                $this->array = [];
                $item->each(function ($item, $key) {
                    foreach ($item->getAttributes() as $key => $value) {
                        if (
                            $key !== 'id' &&
                            $key !== 'parent_id' &&
                            $key !== 'user_id' &&
                            $key !== 'store_id' &&
                            $key !== 'manager_id' &&
                            $key !== 'mileage' &&
                            $key !== 'customer_number' &&
                            $key !== 'rating' &&
                            $key !== 'individual_q1_answer' &&
                            $key !== 'individual_q2_answer'
                        ) {
                            if ($value === 2) {
                                $this->array[] = $key;
                            }
                        }
                    }
                });

                return array_count_values($this->array);
            });

        foreach ($this->managerIssueCount as $name => $answers) {
            foreach ($answers as $question => $answer) {
                if (! isset($this->results[$question])) {
                    $this->results[$question] = [];
                }
                $this->results[$question][$name] = $answer;
                if (! isset($this->results[$question]['Total'])) {
                    $this->results[$question]['Total'] = 0;
                }
                $this->results[$question]['Total'] += $answer;
            }
        }

        // Fill in missing answers for each question
        $allNames = array_keys($this->managerIssueCount->toArray());
        foreach ($this->results as $question => $answers) {
            foreach ($allNames as $name) {
                if (! isset($answers[$name])) {
                    $this->results[$question][$name] = 0;
                }
            }
        }

        // Rearrange "Total" to be at the end of each sub-array
        foreach ($this->results as &$questionAnswers) {
            $total = $questionAnswers['Total'];
            unset($questionAnswers['Total']);
            $questionAnswers['Total'] = $total;
        }

        foreach ($this->managerIssueCount as $name => $answers) {
            $total = array_sum($answers);
            $this->totals[$name] = $total;
            $this->grandTotal += $total;
        }
        $this->totals[] = $this->grandTotal;

        $this->managers = $this->dealJackets
            ->groupBy(fn ($item) => $item->manager->name)
            ->map(function ($item) {
                $this->array = [];
                $item->each(function ($item, $key) {
                    foreach ($item->getAttributes() as $key => $value) {
                        if (
                            $key !== 'id' &&
                            $key !== 'parent_id' &&
                            $key !== 'user_id' &&
                            $key !== 'store_id' &&
                            $key !== 'manager_id' &&
                            $key !== 'mileage' &&
                            $key !== 'customer_number' &&
                            $key !== 'rating' &&
                            $key !== 'individual_q1_answer' &&
                            $key !== 'individual_q2_answer'
                        ) {
                            if ($value === 2) {
                                preg_match('/^[^_]*_q\K[^_]+/', $key, $matches);
                                $comment = $item->getAttributes()['individual_q'.$matches[0].'_comment'];
                                $this->array[] = [$key, $item->customer_number, $key, $comment];
                            }
                        }
                    }
                });

                return collect($this->array)->groupBy(fn ($item) => $item[0]);
            });

        return view('dealer.deal-jacket-audit-pdf', [
            'audit' => IndividualAudit::query()->where('id', 1)->first(),
            'auditCount' => $this->count,
            'audits' => $this->dealJackets,
            'managers' => $this->managers,
            'managerIssueCount' => $this->results,
            'totals' => $this->totals,
        ]);
    }
}
