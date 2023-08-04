<?php

namespace App\Http\Controllers;

use App\Models\User;

class DealJacketPdfTestController extends Controller
{
    public $array = [];
    public $totalQuestions = 0;
    public function __invoke()
    {
//
//        $this->test = IndividualAudit::with('children')->get()->groupBy('manager_id');
//
//                foreach($this->test->getAttributes() as $key => $value) {
//                    if (
//                        $key != 'id' &&
//                        $key != 'parent_id' &&
//                        $key != 'user_id' &&
//                        $key != 'store_id' &&
//                        $key != 'manager_id' &&
//                        $key != 'mileage' &&
//                        $key != 'customer_number' &&
//                        $key != 'rating' &&
//                        $key != 'individual_q1_answer' &&
//                        $key != 'individual_q2_answer'
//                    ) {
//                        if($value === 2) {
//                            $this->array[] = $value;
//                        }
//                        $this->totalQuestions++;
//                    }
//
//        }
//        $this->count = count($this->array);
        return view('dealer.deal-jacket-audit-pdf', [
            'audits' => User::role('Manager')
                ->whereDepartmentId(6)
                ->join('individual_audits', 'users.id', '=', 'individual_audits.manager_id')
            ->get()
        ]);
    }
}
