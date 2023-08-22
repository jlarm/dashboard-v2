<?php

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

    public function __invoke()
    {
        $this->dealJackets = IndividualAudit::query()
            ->with('user')
            ->where('id', 1)
            ->orWhere('parent_id', 1)
            ->get();

        $this->count = $this->dealJackets
            ->groupBy(function ($item) {
                return $item->manager->name;
            })
            ->map(function ($item) {
                $this->array = [];
                $item->each(function ($item, $key) {
                    foreach ($item->getAttributes() as $key => $value) {
                        if (
                            $key != 'id' &&
                            $key != 'parent_id' &&
                            $key != 'user_id' &&
                            $key != 'store_id' &&
                            $key != 'manager_id' &&
                            $key != 'mileage' &&
                            $key != 'customer_number' &&
                            $key != 'rating' &&
                            $key != 'individual_q1_answer' &&
                            $key != 'individual_q2_answer'
                        ) {
                            if ($value === 2) {
                                $this->array[] = $value;
                            }
                        }
                    }
                });
                return count($this->array);
            });

        $this->managers = $this->dealJackets
            ->groupBy(function ($item) {
                return $item->manager->name;
            })
            ->map(function ($item) {
                $this->array = [];
                $item->each(function ($item, $key) {
                    foreach ($item->getAttributes() as $key => $value) {
                        if (
                            $key != 'id' &&
                            $key != 'parent_id' &&
                            $key != 'user_id' &&
                            $key != 'store_id' &&
                            $key != 'manager_id' &&
                            $key != 'mileage' &&
                            $key != 'customer_number' &&
                            $key != 'rating' &&
                            $key != 'individual_q1_answer' &&
                            $key != 'individual_q2_answer'
                        ) {
                            if ($value === 2) {
                                preg_match('/^[^_]*_q\K[^_]+/', $key, $matches);
                                $comment = $item->getAttributes()['individual_q' . $matches[0] . '_comment'];
                                $this->array[] = [$key, $item->customer_number, $key, $comment];
                            }
                        }
                    }
                });
                return collect($this->array)->groupBy(function ($item) {
                    return $item[0];
                });
            });

        return view('dealer.deal-jacket-audit-pdf', [
            'audit' => IndividualAudit::query()->where('id', 1)->first(),
            'auditCount' => $this->count,
            'audits' => $this->dealJackets,
            'managers' => $this->managers,
        ]);
    }
}
