<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use App\Models\IndividualQuestions;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Edit extends Component
{
    use WithMedia;

    public Store $store;

    public IndividualAudit $individualAudit;

    public $managers;

    public $search = '';

    public $mediaComponentNames = [
        'audit_images',
    ];

    public $parent;

    public $draft;

    public $audit_date;

    public $customer_number;

    public $customer_name;

    public $deal_jacket_date;

    public $manager_id;

    public $mileage;

    public $individual_q1_answer;

    public $individual_q1_comment;

    public $individual_q2_answer;

    public $individual_q2_comment;

    public $individual_q3_answer;

    public $individual_q3_comment;

    public $individual_q4_answer;

    public $individual_q4_comment;

    public $individual_q5_answer;

    public $individual_q5_comment;

    public $individual_q6_answer;

    public $individual_q6_comment;

    public $individual_q7_answer;

    public $individual_q7_comment;

    public $individual_q8_answer;

    public $individual_q8_comment;

    public $individual_q9_answer;

    public $individual_q9_comment;

    public $individual_q10_answer;

    public $individual_q10_comment;

    public $individual_q11_answer;

    public $individual_q11_comment;

    public $individual_q12_answer;

    public $individual_q12_comment;

    public $individual_q13_answer;

    public $individual_q13_comment;

    public $individual_q14_answer;

    public $individual_q14_comment;

    public $individual_q15_answer;

    public $individual_q15_comment;

    public $individual_q16_answer;

    public $individual_q16_comment;

    public $individual_q17_answer;

    public $individual_q17_comment;

    public $individual_q18_answer;

    public $individual_q18_comment;

    public $individual_q19_answer;

    public $individual_q19_comment;

    public $individual_q20_answer;

    public $individual_q20_comment;

    public $individual_q21_answer;

    public $individual_q21_comment;

    public $individual_q22_answer;

    public $individual_q22_comment;

    public $individual_q23_answer;

    public $individual_q23_comment;

    public $individual_q24_answer;

    public $individual_q24_comment;

    public $individual_q25_answer;

    public $individual_q25_comment;

    public $individual_q26_answer;

    public $individual_q26_comment;

    public $individual_q27_answer;

    public $individual_q27_comment;

    public $individual_q28_answer;

    public $individual_q28_comment;

    public $individual_q29_answer;

    public $individual_q29_comment;

    public $individual_q30_answer;

    public $individual_q30_comment;

    public $individual_q31_answer;

    public $individual_q31_comment;

    public $individual_q32_answer;

    public $individual_q32_comment;

    public $individual_q33_answer;

    public $individual_q33_comment;

    public $individual_q34_answer;

    public $individual_q34_comment;

    public $individual_q35_answer;

    public $individual_q35_comment;

    public $individual_q36_answer;

    public $individual_q36_comment;

    public $individual_q37_answer;

    public $individual_q37_comment;

    public $individual_q38_answer;

    public $individual_q38_comment;

    public $individual_q39_answer;

    public $individual_q39_comment;

    public $individual_q40_answer;

    public $individual_q40_comment;

    public $audit_images;

    protected $rules = [
        'draft' => 'nullable',
        'audit_date' => 'sometimes',
        'customer_number' => 'nullable',
        'customer_name' => 'nullable',
        'deal_jacket_date' => 'sometimes',
        'manager_id' => 'nullable',
        'mileage' => 'nullable',
        'individual_q1_answer' => 'nullable',
        'individual_q1_comment' => 'nullable',
        'individual_q1_danger' => 'nullable',
        'individual_q2_answer' => 'nullable',
        'individual_q2_comment' => 'nullable',
        'individual_q2_danger' => 'nullable',
        'individual_q3_answer' => 'nullable',
        'individual_q3_comment' => 'nullable',
        'individual_q3_danger' => 'nullable',
        'individual_q4_answer' => 'nullable',
        'individual_q4_comment' => 'nullable',
        'individual_q4_danger' => 'nullable',
        'individual_q5_answer' => 'nullable',
        'individual_q5_comment' => 'nullable',
        'individual_q5_danger' => 'nullable',
        'individual_q6_answer' => 'nullable',
        'individual_q6_comment' => 'nullable',
        'individual_q6_danger' => 'nullable',
        'individual_q7_answer' => 'nullable',
        'individual_q7_comment' => 'nullable',
        'individual_q7_danger' => 'nullable',
        'individual_q8_answer' => 'nullable',
        'individual_q8_comment' => 'nullable',
        'individual_q8_danger' => 'nullable',
        'individual_q9_answer' => 'nullable',
        'individual_q9_comment' => 'nullable',
        'individual_q9_danger' => 'nullable',
        'individual_q10_answer' => 'nullable',
        'individual_q10_comment' => 'nullable',
        'individual_q10_danger' => 'nullable',
        'individual_q11_answer' => 'nullable',
        'individual_q11_comment' => 'nullable',
        'individual_q11_danger' => 'nullable',
        'individual_q12_answer' => 'nullable',
        'individual_q12_comment' => 'nullable',
        'individual_q12_danger' => 'nullable',
        'individual_q13_answer' => 'nullable',
        'individual_q13_comment' => 'nullable',
        'individual_q13_danger' => 'nullable',
        'individual_q14_answer' => 'nullable',
        'individual_q14_comment' => 'nullable',
        'individual_q14_danger' => 'nullable',
        'individual_q15_answer' => 'nullable',
        'individual_q15_comment' => 'nullable',
        'individual_q15_danger' => 'nullable',
        'individual_q16_answer' => 'nullable',
        'individual_q16_comment' => 'nullable',
        'individual_q16_danger' => 'nullable',
        'individual_q17_answer' => 'nullable',
        'individual_q17_comment' => 'nullable',
        'individual_q17_danger' => 'nullable',
        'individual_q18_answer' => 'nullable',
        'individual_q18_comment' => 'nullable',
        'individual_q18_danger' => 'nullable',
        'individual_q19_answer' => 'nullable',
        'individual_q19_comment' => 'nullable',
        'individual_q19_danger' => 'nullable',
        'individual_q20_answer' => 'nullable',
        'individual_q20_comment' => 'nullable',
        'individual_q20_danger' => 'nullable',
        'individual_q21_answer' => 'nullable',
        'individual_q21_comment' => 'nullable',
        'individual_q21_danger' => 'nullable',
        'individual_q22_answer' => 'nullable',
        'individual_q22_comment' => 'nullable',
        'individual_q22_danger' => 'nullable',
        'individual_q23_answer' => 'nullable',
        'individual_q23_comment' => 'nullable',
        'individual_q23_danger' => 'nullable',
        'individual_q24_answer' => 'nullable',
        'individual_q24_comment' => 'nullable',
        'individual_q24_danger' => 'nullable',
        'individual_q25_answer' => 'nullable',
        'individual_q25_comment' => 'nullable',
        'individual_q25_danger' => 'nullable',
        'individual_q26_answer' => 'nullable',
        'individual_q26_comment' => 'nullable',
        'individual_q26_danger' => 'nullable',
        'individual_q27_answer' => 'nullable',
        'individual_q27_comment' => 'nullable',
        'individual_q27_danger' => 'nullable',
        'individual_q28_answer' => 'nullable',
        'individual_q28_comment' => 'nullable',
        'individual_q28_danger' => 'nullable',
        'individual_q29_answer' => 'nullable',
        'individual_q29_comment' => 'nullable',
        'individual_q29_danger' => 'nullable',
        'individual_q30_answer' => 'nullable',
        'individual_q30_comment' => 'nullable',
        'individual_q30_danger' => 'nullable',
        'individual_q31_answer' => 'nullable',
        'individual_q31_comment' => 'nullable',
        'individual_q31_danger' => 'nullable',
        'individual_q32_answer' => 'nullable',
        'individual_q32_comment' => 'nullable',
        'individual_q32_danger' => 'nullable',
        'individual_q33_answer' => 'nullable',
        'individual_q33_comment' => 'nullable',
        'individual_q33_danger' => 'nullable',
        'individual_q34_answer' => 'nullable',
        'individual_q34_comment' => 'nullable',
        'individual_q34_danger' => 'nullable',
        'individual_q35_answer' => 'nullable',
        'individual_q35_comment' => 'nullable',
        'individual_q35_danger' => 'nullable',
        'individual_q36_answer' => 'nullable',
        'individual_q36_comment' => 'nullable',
        'individual_q36_danger' => 'nullable',
        'individual_q37_answer' => 'nullable',
        'individual_q37_comment' => 'nullable',
        'individual_q37_danger' => 'nullable',
        'individual_q38_answer' => 'nullable',
        'individual_q38_comment' => 'nullable',
        'individual_q38_danger' => 'nullable',
        'individual_q39_answer' => 'nullable',
        'individual_q39_comment' => 'nullable',
        'individual_q39_danger' => 'nullable',
        'individual_q40_answer' => 'nullable',
        'individual_q40_comment' => 'nullable',
        'individual_q40_danger' => 'nullable',
        'audit_images' => 'nullable',
    ];

    public function mount()
    {
        $this->managers = User::role('manager')->whereDepartmentId(6)->select('id', 'name')->get();
        $this->parent = $this->individualAudit->parent ?? $this->individualAudit;
        $this->draft = $this->individualAudit->draft;
        $this->audit_date = Carbon::make($this->individualAudit->audit_date)->format('Y-m-d');
        $this->customer_number = $this->individualAudit->customer_number;
        $this->customer_name = $this->individualAudit->customer_name;
        $this->deal_jacket_date = ($this->individualAudit->deal_jacket_date) ? Carbon::make($this->individualAudit->deal_jacket_date)->format('Y-m-d') : null;
        $this->manager_id = $this->individualAudit->manager_id;
        $this->mileage = $this->individualAudit->mileage;
        $this->individual_q1_answer = $this->individualAudit->individual_q1_answer;
        $this->individual_q1_comment = $this->individualAudit->individual_q1_comment;
        $this->individual_q1_danger = $this->individualAudit->individual_q1_danger;
        $this->individual_q2_answer = $this->individualAudit->individual_q2_answer;
        $this->individual_q2_comment = $this->individualAudit->individual_q2_comment;
        $this->individual_q2_danger = $this->individualAudit->individual_q2_danger;
        $this->individual_q3_answer = $this->individualAudit->individual_q3_answer;
        $this->individual_q3_comment = $this->individualAudit->individual_q3_comment;
        $this->individual_q3_danger = $this->individualAudit->individual_q3_danger;
        $this->individual_q4_answer = $this->individualAudit->individual_q4_answer;
        $this->individual_q4_comment = $this->individualAudit->individual_q4_comment;
        $this->individual_q4_danger = $this->individualAudit->individual_q4_danger;
        $this->individual_q5_answer = $this->individualAudit->individual_q5_answer;
        $this->individual_q5_comment = $this->individualAudit->individual_q5_comment;
        $this->individual_q5_danger = $this->individualAudit->individual_q5_danger;
        $this->individual_q6_answer = $this->individualAudit->individual_q6_answer;
        $this->individual_q6_comment = $this->individualAudit->individual_q6_comment;
        $this->individual_q6_danger = $this->individualAudit->individual_q6_danger;
        $this->individual_q7_answer = $this->individualAudit->individual_q7_answer;
        $this->individual_q7_comment = $this->individualAudit->individual_q7_comment;
        $this->individual_q7_danger = $this->individualAudit->individual_q7_danger;
        $this->individual_q8_answer = $this->individualAudit->individual_q8_answer;
        $this->individual_q8_comment = $this->individualAudit->individual_q8_comment;
        $this->individual_q8_danger = $this->individualAudit->individual_q8_danger;
        $this->individual_q9_answer = $this->individualAudit->individual_q9_answer;
        $this->individual_q9_comment = $this->individualAudit->individual_q9_comment;
        $this->individual_q9_danger = $this->individualAudit->individual_q9_danger;
        $this->individual_q10_answer = $this->individualAudit->individual_q10_answer;
        $this->individual_q10_comment = $this->individualAudit->individual_q10_comment;
        $this->individual_q10_danger = $this->individualAudit->individual_q10_danger;
        $this->individual_q11_answer = $this->individualAudit->individual_q11_answer;
        $this->individual_q11_comment = $this->individualAudit->individual_q11_comment;
        $this->individual_q11_danger = $this->individualAudit->individual_q11_danger;
        $this->individual_q12_answer = $this->individualAudit->individual_q12_answer;
        $this->individual_q12_comment = $this->individualAudit->individual_q12_comment;
        $this->individual_q12_danger = $this->individualAudit->individual_q12_danger;
        $this->individual_q13_answer = $this->individualAudit->individual_q13_answer;
        $this->individual_q13_comment = $this->individualAudit->individual_q13_comment;
        $this->individual_q13_danger = $this->individualAudit->individual_q13_danger;
        $this->individual_q14_answer = $this->individualAudit->individual_q14_answer;
        $this->individual_q14_comment = $this->individualAudit->individual_q14_comment;
        $this->individual_q14_danger = $this->individualAudit->individual_q14_danger;
        $this->individual_q15_answer = $this->individualAudit->individual_q15_answer;
        $this->individual_q15_comment = $this->individualAudit->individual_q15_comment;
        $this->individual_q15_danger = $this->individualAudit->individual_q15_danger;
        $this->individual_q16_answer = $this->individualAudit->individual_q16_answer;
        $this->individual_q16_comment = $this->individualAudit->individual_q16_comment;
        $this->individual_q16_danger = $this->individualAudit->individual_q16_danger;
        $this->individual_q17_answer = $this->individualAudit->individual_q17_answer;
        $this->individual_q17_comment = $this->individualAudit->individual_q17_comment;
        $this->individual_q17_danger = $this->individualAudit->individual_q17_danger;
        $this->individual_q18_answer = $this->individualAudit->individual_q18_answer;
        $this->individual_q18_comment = $this->individualAudit->individual_q18_comment;
        $this->individual_q18_danger = $this->individualAudit->individual_q18_danger;
        $this->individual_q19_answer = $this->individualAudit->individual_q19_answer;
        $this->individual_q19_comment = $this->individualAudit->individual_q19_comment;
        $this->individual_q19_danger = $this->individualAudit->individual_q19_danger;
        $this->individual_q20_answer = $this->individualAudit->individual_q20_answer;
        $this->individual_q20_comment = $this->individualAudit->individual_q20_comment;
        $this->individual_q20_danger = $this->individualAudit->individual_q20_danger;
        $this->individual_q21_answer = $this->individualAudit->individual_q21_answer;
        $this->individual_q21_comment = $this->individualAudit->individual_q21_comment;
        $this->individual_q21_danger = $this->individualAudit->individual_q21_danger;
        $this->individual_q22_answer = $this->individualAudit->individual_q22_answer;
        $this->individual_q22_comment = $this->individualAudit->individual_q22_comment;
        $this->individual_q22_danger = $this->individualAudit->individual_q22_danger;
        $this->individual_q23_answer = $this->individualAudit->individual_q23_answer;
        $this->individual_q23_comment = $this->individualAudit->individual_q23_comment;
        $this->individual_q23_danger = $this->individualAudit->individual_q23_danger;
        $this->individual_q24_answer = $this->individualAudit->individual_q24_answer;
        $this->individual_q24_comment = $this->individualAudit->individual_q24_comment;
        $this->individual_q24_danger = $this->individualAudit->individual_q24_danger;
        $this->individual_q25_answer = $this->individualAudit->individual_q25_answer;
        $this->individual_q25_comment = $this->individualAudit->individual_q25_comment;
        $this->individual_q25_danger = $this->individualAudit->individual_q25_danger;
        $this->individual_q26_answer = $this->individualAudit->individual_q26_answer;
        $this->individual_q26_comment = $this->individualAudit->individual_q26_comment;
        $this->individual_q26_danger = $this->individualAudit->individual_q26_danger;
        $this->individual_q27_answer = $this->individualAudit->individual_q27_answer;
        $this->individual_q27_comment = $this->individualAudit->individual_q27_comment;
        $this->individual_q27_danger = $this->individualAudit->individual_q27_danger;
        $this->individual_q28_answer = $this->individualAudit->individual_q28_answer;
        $this->individual_q28_comment = $this->individualAudit->individual_q28_comment;
        $this->individual_q28_danger = $this->individualAudit->individual_q28_danger;
        $this->individual_q29_answer = $this->individualAudit->individual_q29_answer;
        $this->individual_q29_comment = $this->individualAudit->individual_q29_comment;
        $this->individual_q29_danger = $this->individualAudit->individual_q29_danger;
        $this->individual_q30_answer = $this->individualAudit->individual_q30_answer;
        $this->individual_q30_comment = $this->individualAudit->individual_q30_comment;
        $this->individual_q30_danger = $this->individualAudit->individual_q30_danger;
        $this->individual_q31_answer = $this->individualAudit->individual_q31_answer;
        $this->individual_q31_comment = $this->individualAudit->individual_q31_comment;
        $this->individual_q31_danger = $this->individualAudit->individual_q31_danger;
        $this->individual_q32_answer = $this->individualAudit->individual_q32_answer;
        $this->individual_q32_comment = $this->individualAudit->individual_q32_comment;
        $this->individual_q32_danger = $this->individualAudit->individual_q32_danger;
        $this->individual_q33_answer = $this->individualAudit->individual_q33_answer;
        $this->individual_q33_comment = $this->individualAudit->individual_q33_comment;
        $this->individual_q33_danger = $this->individualAudit->individual_q33_danger;
        $this->individual_q34_answer = $this->individualAudit->individual_q34_answer;
        $this->individual_q34_comment = $this->individualAudit->individual_q34_comment;
        $this->individual_q34_danger = $this->individualAudit->individual_q34_danger;
        $this->individual_q35_answer = $this->individualAudit->individual_q35_answer;
        $this->individual_q35_comment = $this->individualAudit->individual_q35_comment;
        $this->individual_q35_danger = $this->individualAudit->individual_q35_danger;
        $this->individual_q36_answer = $this->individualAudit->individual_q36_answer;
        $this->individual_q36_comment = $this->individualAudit->individual_q36_comment;
        $this->individual_q36_danger = $this->individualAudit->individual_q36_danger;
        $this->individual_q37_answer = $this->individualAudit->individual_q37_answer;
        $this->individual_q37_comment = $this->individualAudit->individual_q37_comment;
        $this->individual_q37_danger = $this->individualAudit->individual_q37_danger;
        $this->individual_q38_answer = $this->individualAudit->individual_q38_answer;
        $this->individual_q38_comment = $this->individualAudit->individual_q38_comment;
        $this->individual_q38_danger = $this->individualAudit->individual_q38_danger;
        $this->individual_q39_answer = $this->individualAudit->individual_q39_answer;
        $this->individual_q39_comment = $this->individualAudit->individual_q39_comment;
        $this->individual_q39_danger = $this->individualAudit->individual_q39_danger;
        $this->individual_q40_answer = $this->individualAudit->individual_q40_answer;
        $this->individual_q40_comment = $this->individualAudit->individual_q40_comment;
        $this->individual_q40_danger = $this->individualAudit->individual_q40_danger;
    }

    public function update($exit, Store $store)
    {
        $this->validate();

        $this->individualAudit->update([
            'draft' => $this->draft,
            'audit_date' => $this->audit_date,
            'customer_number' => $this->customer_number,
            'customer_name' => $this->customer_name,
            'deal_jacket_date' => $this->deal_jacket_date,
            'manager_id' => $this->manager_id,
            'mileage' => $this->mileage,
            'individual_q1_answer' => $this->individual_q1_answer,
            'individual_q1_comment' => $this->individual_q1_comment,
            'individual_q1_danger' => $this->individual_q1_danger,
            'individual_q2_answer' => $this->individual_q2_answer,
            'individual_q2_comment' => $this->individual_q2_comment,
            'individual_q2_danger' => $this->individual_q2_danger,
            'individual_q3_answer' => $this->individual_q3_answer,
            'individual_q3_comment' => $this->individual_q3_comment,
            'individual_q3_danger' => $this->individual_q3_danger,
            'individual_q4_answer' => $this->individual_q4_answer,
            'individual_q4_comment' => $this->individual_q4_comment,
            'individual_q4_danger' => $this->individual_q4_danger,
            'individual_q5_answer' => $this->individual_q5_answer,
            'individual_q5_comment' => $this->individual_q5_comment,
            'individual_q5_danger' => $this->individual_q5_danger,
            'individual_q6_answer' => $this->individual_q6_answer,
            'individual_q6_comment' => $this->individual_q6_comment,
            'individual_q6_danger' => $this->individual_q6_danger,
            'individual_q7_answer' => $this->individual_q7_answer,
            'individual_q7_comment' => $this->individual_q7_comment,
            'individual_q7_danger' => $this->individual_q7_danger,
            'individual_q8_answer' => $this->individual_q8_answer,
            'individual_q8_comment' => $this->individual_q8_comment,
            'individual_q8_danger' => $this->individual_q8_danger,
            'individual_q9_answer' => $this->individual_q9_answer,
            'individual_q9_comment' => $this->individual_q9_comment,
            'individual_q9_danger' => $this->individual_q9_danger,
            'individual_q10_answer' => $this->individual_q10_answer,
            'individual_q10_comment' => $this->individual_q10_comment,
            'individual_q10_danger' => $this->individual_q10_danger,
            'individual_q11_answer' => $this->individual_q11_answer,
            'individual_q11_comment' => $this->individual_q11_comment,
            'individual_q11_danger' => $this->individual_q11_danger,
            'individual_q12_answer' => $this->individual_q12_answer,
            'individual_q12_comment' => $this->individual_q12_comment,
            'individual_q12_danger' => $this->individual_q12_danger,
            'individual_q13_answer' => $this->individual_q13_answer,
            'individual_q13_comment' => $this->individual_q13_comment,
            'individual_q13_danger' => $this->individual_q13_danger,
            'individual_q14_answer' => $this->individual_q14_answer,
            'individual_q14_comment' => $this->individual_q14_comment,
            'individual_q14_danger' => $this->individual_q14_danger,
            'individual_q15_answer' => $this->individual_q15_answer,
            'individual_q15_comment' => $this->individual_q15_comment,
            'individual_q15_danger' => $this->individual_q15_danger,
            'individual_q16_answer' => $this->individual_q16_answer,
            'individual_q16_comment' => $this->individual_q16_comment,
            'individual_q16_danger' => $this->individual_q16_danger,
            'individual_q17_answer' => $this->individual_q17_answer,
            'individual_q17_comment' => $this->individual_q17_comment,
            'individual_q17_danger' => $this->individual_q17_danger,
            'individual_q18_answer' => $this->individual_q18_answer,
            'individual_q18_comment' => $this->individual_q18_comment,
            'individual_q18_danger' => $this->individual_q18_danger,
            'individual_q19_answer' => $this->individual_q19_answer,
            'individual_q19_comment' => $this->individual_q19_comment,
            'individual_q19_danger' => $this->individual_q19_danger,
            'individual_q20_answer' => $this->individual_q20_answer,
            'individual_q20_comment' => $this->individual_q20_comment,
            'individual_q20_danger' => $this->individual_q20_danger,
            'individual_q21_answer' => $this->individual_q21_answer,
            'individual_q21_comment' => $this->individual_q21_comment,
            'individual_q21_danger' => $this->individual_q21_danger,
            'individual_q22_answer' => $this->individual_q22_answer,
            'individual_q22_comment' => $this->individual_q22_comment,
            'individual_q22_danger' => $this->individual_q22_danger,
            'individual_q23_answer' => $this->individual_q23_answer,
            'individual_q23_comment' => $this->individual_q23_comment,
            'individual_q23_danger' => $this->individual_q23_danger,
            'individual_q24_answer' => $this->individual_q24_answer,
            'individual_q24_comment' => $this->individual_q24_comment,
            'individual_q24_danger' => $this->individual_q24_danger,
            'individual_q25_answer' => $this->individual_q25_answer,
            'individual_q25_comment' => $this->individual_q25_comment,
            'individual_q25_danger' => $this->individual_q25_danger,
            'individual_q26_answer' => $this->individual_q26_answer,
            'individual_q26_comment' => $this->individual_q26_comment,
            'individual_q26_danger' => $this->individual_q26_danger,
            'individual_q27_answer' => $this->individual_q27_answer,
            'individual_q27_comment' => $this->individual_q27_comment,
            'individual_q27_danger' => $this->individual_q27_danger,
            'individual_q28_answer' => $this->individual_q28_answer,
            'individual_q28_comment' => $this->individual_q28_comment,
            'individual_q28_danger' => $this->individual_q28_danger,
            'individual_q29_answer' => $this->individual_q29_answer,
            'individual_q29_comment' => $this->individual_q29_comment,
            'individual_q29_danger' => $this->individual_q29_danger,
            'individual_q30_answer' => $this->individual_q30_answer,
            'individual_q30_comment' => $this->individual_q30_comment,
            'individual_q30_danger' => $this->individual_q30_danger,
            'individual_q31_answer' => $this->individual_q31_answer,
            'individual_q31_comment' => $this->individual_q31_comment,
            'individual_q31_danger' => $this->individual_q31_danger,
            'individual_q32_answer' => $this->individual_q32_answer,
            'individual_q32_comment' => $this->individual_q32_comment,
            'individual_q32_danger' => $this->individual_q32_danger,
            'individual_q33_answer' => $this->individual_q33_answer,
            'individual_q33_comment' => $this->individual_q33_comment,
            'individual_q33_danger' => $this->individual_q33_danger,
            'individual_q34_answer' => $this->individual_q34_answer,
            'individual_q34_comment' => $this->individual_q34_comment,
            'individual_q34_danger' => $this->individual_q34_danger,
            'individual_q35_answer' => $this->individual_q35_answer,
            'individual_q35_comment' => $this->individual_q35_comment,
            'individual_q35_danger' => $this->individual_q35_danger,
            'individual_q36_answer' => $this->individual_q36_answer,
            'individual_q36_comment' => $this->individual_q36_comment,
            'individual_q36_danger' => $this->individual_q36_danger,
            'individual_q37_answer' => $this->individual_q37_answer,
            'individual_q37_comment' => $this->individual_q37_comment,
            'individual_q37_danger' => $this->individual_q37_danger,
            'individual_q38_answer' => $this->individual_q38_answer,
            'individual_q38_comment' => $this->individual_q38_comment,
            'individual_q38_danger' => $this->individual_q38_danger,
            'individual_q39_answer' => $this->individual_q39_answer,
            'individual_q39_comment' => $this->individual_q39_comment,
            'individual_q39_danger' => $this->individual_q39_danger,
            'individual_q40_answer' => $this->individual_q40_answer,
            'individual_q40_comment' => $this->individual_q40_comment,
            'individual_q40_danger' => $this->individual_q40_danger,
        ]);

        $this->individualAudit->syncFromMediaLibraryRequest($this->audit_images)
            ->toMediaCollection('individual_audit_images', 'digitalocean');

        Notification::make()
            ->title('Deal Jacket Audit Updated Successfully!')
            ->success()
            ->send();

        if (! $this->individualAudit->parent_id) {
            $parent = $this->individualAudit;
        } else {
            $parent = IndividualAudit::where('id', $this->individualAudit->parent_id)->first();
        }

        if ($exit) {
            if (! tenant('locations')) {
                return redirect()->route('dealer.audit.individual.show', $parent);
            }

            return redirect()->route('dealer.stores.audits.individual.show', [$store, $parent]);
        }
    }

    public function render()
    {
        return view('livewire.dealer.audit.individual.edit', [
            'questions' => tenancy()->central(function ($tenant) {
                return IndividualQuestions::query()->search('question', $this->search)->get();
            }),
        ]);
    }
}
