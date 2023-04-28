<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Show extends Component
{
    use WithMedia;

    public Store $store;
    public FinanceAudit $financeAudit;

    public $mediaComponentNames = [
        'finance_q1_images',
        'finance_q2_images',
        'finance_q3_images',
        'finance_q4_images',
        'finance_q5_images',
        'finance_q6_images',
        'finance_q7_images',
        'finance_q8_images',
        'finance_q9_images',
        'finance_q10_images',
        'finance_q11_images',
        'finance_q12_images',
        'finance_q13_images',
        'finance_q14_images',
        'finance_q15_images',
        'finance_q16_images',
        'finance_q17_images',
        'finance_q18_images',
        'finance_q19_images',
        'finance_q20_images',
        'finance_q21_images',
        'finance_q22_images',
        'finance_q23_images',
        'finance_q24_images',
        'finance_q25_images',
        'finance_q26_images',
        'finance_q27_images',
        'finance_q28_images',
        'finance_q29_images',
        'finance_q30_images',
        'finance_q31_images',
        'finance_q32_images',
        'finance_q33_images',
        'finance_q34_images',
        'finance_q35_images',
        'finance_q36_images',
        'finance_q37_images',
        'finance_q38_images',
        'finance_q39_images',
        'finance_q40_images',
        'finance_q41_images',
        'finance_q42_images',
        'finance_q43_images',
        'finance_q44_images',
        'finance_q45_images',
        'finance_q46_images',
        'finance_q47_images',
        'finance_q48_images',
        'finance_q49_images'
    ];

    public $draft;
    public $finance_q1_answer;
    public $finance_q1_comment;
    public $finance_q1_images;
    public $finance_q2_answer;
    public $finance_q2_comment;
    public $finance_q2_images;
    public $finance_q3_answer;
    public $finance_q3_comment;
    public $finance_q3_images;
    public $finance_q4_answer;
    public $finance_q4_comment;
    public $finance_q4_images;
    public $finance_q5_answer;
    public $finance_q5_comment;
    public $finance_q5_images;
    public $finance_q6_answer;
    public $finance_q6_comment;
    public $finance_q6_images;
    public $finance_q7_answer;
    public $finance_q7_comment;
    public $finance_q7_images;
    public $finance_q8_answer;
    public $finance_q8_comment;
    public $finance_q8_images;
    public $finance_q9_answer;
    public $finance_q9_comment;
    public $finance_q9_images;
    public $finance_q10_answer;
    public $finance_q10_comment;
    public $finance_q10_images;
    public $finance_q11_answer;
    public $finance_q11_comment;
    public $finance_q11_images;
    public $finance_q12_answer;
    public $finance_q12_comment;
    public $finance_q12_images;
    public $finance_q13_answer;
    public $finance_q13_comment;
    public $finance_q13_images;
    public $finance_q14_answer;
    public $finance_q14_comment;
    public $finance_q14_images;
    public $finance_q15_answer;
    public $finance_q15_comment;
    public $finance_q15_images;
    public $finance_q16_answer;
    public $finance_q16_comment;
    public $finance_q16_images;
    public $finance_q17_answer;
    public $finance_q17_comment;
    public $finance_q17_images;
    public $finance_q18_answer;
    public $finance_q18_comment;
    public $finance_q18_images;
    public $finance_q19_answer;
    public $finance_q19_comment;
    public $finance_q19_images;
    public $finance_q20_answer;
    public $finance_q20_comment;
    public $finance_q20_images;
    public $finance_q21_answer;
    public $finance_q21_comment;
    public $finance_q21_images;
    public $finance_q22_answer;
    public $finance_q22_comment;
    public $finance_q22_images;
    public $finance_q23_answer;
    public $finance_q23_comment;
    public $finance_q23_images;
    public $finance_q24_answer;
    public $finance_q24_comment;
    public $finance_q24_images;
    public $finance_q25_answer;
    public $finance_q25_comment;
    public $finance_q25_images;
    public $finance_q26_answer;
    public $finance_q26_comment;
    public $finance_q26_images;
    public $finance_q27_answer;
    public $finance_q27_comment;
    public $finance_q27_images;
    public $finance_q28_answer;
    public $finance_q28_comment;
    public $finance_q28_images;
    public $finance_q29_answer;
    public $finance_q29_comment;
    public $finance_q29_images;
    public $finance_q30_answer;
    public $finance_q30_comment;
    public $finance_q30_images;
    public $finance_q31_answer;
    public $finance_q31_comment;
    public $finance_q31_images;
    public $finance_q32_answer;
    public $finance_q32_comment;
    public $finance_q32_images;
    public $finance_q33_answer;
    public $finance_q33_comment;
    public $finance_q33_images;
    public $finance_q34_answer;
    public $finance_q34_comment;
    public $finance_q34_images;
    public $finance_q35_answer;
    public $finance_q35_comment;
    public $finance_q35_images;
    public $finance_q36_answer;
    public $finance_q36_comment;
    public $finance_q36_images;
    public $finance_q37_answer;
    public $finance_q37_comment;
    public $finance_q37_images;
    public $finance_q38_answer;
    public $finance_q38_comment;
    public $finance_q38_images;
    public $finance_q39_answer;
    public $finance_q39_comment;
    public $finance_q39_images;
    public $finance_q40_answer;
    public $finance_q40_comment;
    public $finance_q40_images;
    public $finance_q41_answer;
    public $finance_q41_comment;
    public $finance_q41_images;
    public $finance_q42_answer;
    public $finance_q42_comment;
    public $finance_q42_images;
    public $finance_q43_answer;
    public $finance_q43_comment;
    public $finance_q43_images;
    public $finance_q44_answer;
    public $finance_q44_comment;
    public $finance_q44_images;
    public $finance_q45_answer;
    public $finance_q45_comment;
    public $finance_q45_images;
    public $finance_q46_answer;
    public $finance_q46_comment;
    public $finance_q46_images;
    public $finance_q47_answer;
    public $finance_q47_comment;
    public $finance_q47_images;
    public $finance_q48_answer;
    public $finance_q48_comment;
    public $finance_q48_images;
    public $finance_q49_answer;
    public $finance_q49_comment;
    public $finance_q49_images;

    protected $rules = [
        'draft' => 'nullable',
        'finance_q1_answer' => 'nullable',
        'finance_q1_comment' => 'nullable',
        'finance_q1_images' => 'nullable',
        'finance_q2_answer' => 'nullable',
        'finance_q2_comment' => 'nullable',
        'finance_q2_images' => 'nullable',
        'finance_q3_answer' => 'nullable',
        'finance_q3_comment' => 'nullable',
        'finance_q3_images' => 'nullable',
        'finance_q4_answer' => 'nullable',
        'finance_q4_comment' => 'nullable',
        'finance_q4_images' => 'nullable',
        'finance_q5_answer' => 'nullable',
        'finance_q5_comment' => 'nullable',
        'finance_q5_images' => 'nullable',
        'finance_q6_answer' => 'nullable',
        'finance_q6_comment' => 'nullable',
        'finance_q6_images' => 'nullable',
        'finance_q7_answer' => 'nullable',
        'finance_q7_comment' => 'nullable',
        'finance_q7_images' => 'nullable',
        'finance_q8_answer' => 'nullable',
        'finance_q8_comment' => 'nullable',
        'finance_q8_images' => 'nullable',
        'finance_q9_answer' => 'nullable',
        'finance_q9_comment' => 'nullable',
        'finance_q9_images' => 'nullable',
        'finance_q10_answer' => 'nullable',
        'finance_q10_comment' => 'nullable',
        'finance_q10_images' => 'nullable',
        'finance_q11_answer' => 'nullable',
        'finance_q11_comment' => 'nullable',
        'finance_q11_images' => 'nullable',
        'finance_q12_answer' => 'nullable',
        'finance_q12_comment' => 'nullable',
        'finance_q12_images' => 'nullable',
        'finance_q13_answer' => 'nullable',
        'finance_q13_comment' => 'nullable',
        'finance_q13_images' => 'nullable',
        'finance_q14_answer' => 'nullable',
        'finance_q14_comment' => 'nullable',
        'finance_q14_images' => 'nullable',
        'finance_q15_answer' => 'nullable',
        'finance_q15_comment' => 'nullable',
        'finance_q15_images' => 'nullable',
        'finance_q16_answer' => 'nullable',
        'finance_q16_comment' => 'nullable',
        'finance_q16_images' => 'nullable',
        'finance_q17_answer' => 'nullable',
        'finance_q17_comment' => 'nullable',
        'finance_q17_images' => 'nullable',
        'finance_q18_answer' => 'nullable',
        'finance_q18_comment' => 'nullable',
        'finance_q18_images' => 'nullable',
        'finance_q19_answer' => 'nullable',
        'finance_q19_comment' => 'nullable',
        'finance_q19_images' => 'nullable',
        'finance_q20_answer' => 'nullable',
        'finance_q20_comment' => 'nullable',
        'finance_q20_images' => 'nullable',
        'finance_q21_answer' => 'nullable',
        'finance_q21_comment' => 'nullable',
        'finance_q21_images' => 'nullable',
        'finance_q22_answer' => 'nullable',
        'finance_q22_comment' => 'nullable',
        'finance_q22_images' => 'nullable',
        'finance_q23_answer' => 'nullable',
        'finance_q23_comment' => 'nullable',
        'finance_q23_images' => 'nullable',
        'finance_q24_answer' => 'nullable',
        'finance_q24_comment' => 'nullable',
        'finance_q24_images' => 'nullable',
        'finance_q25_answer' => 'nullable',
        'finance_q25_comment' => 'nullable',
        'finance_q25_images' => 'nullable',
        'finance_q26_answer' => 'nullable',
        'finance_q26_comment' => 'nullable',
        'finance_q26_images' => 'nullable',
        'finance_q27_answer' => 'nullable',
        'finance_q27_comment' => 'nullable',
        'finance_q27_images' => 'nullable',
        'finance_q28_answer' => 'nullable',
        'finance_q28_comment' => 'nullable',
        'finance_q28_images' => 'nullable',
        'finance_q29_answer' => 'nullable',
        'finance_q29_comment' => 'nullable',
        'finance_q29_images' => 'nullable',
        'finance_q30_answer' => 'nullable',
        'finance_q30_comment' => 'nullable',
        'finance_q30_images' => 'nullable',
        'finance_q31_answer' => 'nullable',
        'finance_q31_comment' => 'nullable',
        'finance_q31_images' => 'nullable',
        'finance_q32_answer' => 'nullable',
        'finance_q32_comment' => 'nullable',
        'finance_q32_images' => 'nullable',
        'finance_q33_answer' => 'nullable',
        'finance_q33_comment' => 'nullable',
        'finance_q33_images' => 'nullable',
        'finance_q34_answer' => 'nullable',
        'finance_q34_comment' => 'nullable',
        'finance_q34_images' => 'nullable',
        'finance_q35_answer' => 'nullable',
        'finance_q35_comment' => 'nullable',
        'finance_q35_images' => 'nullable',
        'finance_q36_answer' => 'nullable',
        'finance_q36_comment' => 'nullable',
        'finance_q36_images' => 'nullable',
        'finance_q37_answer' => 'nullable',
        'finance_q37_comment' => 'nullable',
        'finance_q37_images' => 'nullable',
        'finance_q38_answer' => 'nullable',
        'finance_q38_comment' => 'nullable',
        'finance_q38_images' => 'nullable',
        'finance_q39_answer' => 'nullable',
        'finance_q39_comment' => 'nullable',
        'finance_q39_images' => 'nullable',
        'finance_q40_answer' => 'nullable',
        'finance_q40_comment' => 'nullable',
        'finance_q40_images' => 'nullable',
        'finance_q41_answer' => 'nullable',
        'finance_q41_comment' => 'nullable',
        'finance_q41_images' => 'nullable',
        'finance_q42_answer' => 'nullable',
        'finance_q42_comment' => 'nullable',
        'finance_q42_images' => 'nullable',
        'finance_q43_answer' => 'nullable',
        'finance_q43_comment' => 'nullable',
        'finance_q43_images' => 'nullable',
        'finance_q44_answer' => 'nullable',
        'finance_q44_comment' => 'nullable',
        'finance_q44_images' => 'nullable',
        'finance_q45_answer' => 'nullable',
        'finance_q45_comment' => 'nullable',
        'finance_q45_images' => 'nullable',
        'finance_q46_answer' => 'nullable',
        'finance_q46_comment' => 'nullable',
        'finance_q46_images' => 'nullable',
        'finance_q47_answer' => 'nullable',
        'finance_q47_comment' => 'nullable',
        'finance_q47_images' => 'nullable',
        'finance_q48_answer' => 'nullable',
        'finance_q48_comment' => 'nullable',
        'finance_q48_images' => 'nullable',
        'finance_q49_answer' => 'nullable',
        'finance_q49_comment' => 'nullable',
        'finance_q49_images' => 'nullable'
    ];

    public function mount()
    {
        $this->draft = $this->financeAudit->draft;
        $this->finance_q1_answer = $this->financeAudit->finance_q1_answer;
        $this->finance_q1_comment = $this->financeAudit->finance_q1_comment;
        $this->finance_q2_answer = $this->financeAudit->finance_q2_answer;
        $this->finance_q2_comment = $this->financeAudit->finance_q2_comment;
        $this->finance_q3_answer = $this->financeAudit->finance_q3_answer;
        $this->finance_q3_comment = $this->financeAudit->finance_q3_comment;
        $this->finance_q4_answer = $this->financeAudit->finance_q4_answer;
        $this->finance_q4_comment = $this->financeAudit->finance_q4_comment;
        $this->finance_q5_answer = $this->financeAudit->finance_q5_answer;
        $this->finance_q5_comment = $this->financeAudit->finance_q5_comment;
        $this->finance_q6_answer = $this->financeAudit->finance_q6_answer;
        $this->finance_q6_comment = $this->financeAudit->finance_q6_comment;
        $this->finance_q7_answer = $this->financeAudit->finance_q7_answer;
        $this->finance_q7_comment = $this->financeAudit->finance_q7_comment;
        $this->finance_q8_answer = $this->financeAudit->finance_q8_answer;
        $this->finance_q8_comment = $this->financeAudit->finance_q8_comment;
        $this->finance_q9_answer = $this->financeAudit->finance_q9_answer;
        $this->finance_q9_comment = $this->financeAudit->finance_q9_comment;
        $this->finance_q10_answer = $this->financeAudit->finance_q10_answer;
        $this->finance_q10_comment = $this->financeAudit->finance_q10_comment;
        $this->finance_q11_answer = $this->financeAudit->finance_q11_answer;
        $this->finance_q11_comment = $this->financeAudit->finance_q11_comment;
        $this->finance_q12_answer = $this->financeAudit->finance_q12_answer;
        $this->finance_q12_comment = $this->financeAudit->finance_q12_comment;
        $this->finance_q13_answer = $this->financeAudit->finance_q13_answer;
        $this->finance_q13_comment = $this->financeAudit->finance_q13_comment;
        $this->finance_q14_answer = $this->financeAudit->finance_q14_answer;
        $this->finance_q14_comment = $this->financeAudit->finance_q14_comment;
        $this->finance_q15_answer = $this->financeAudit->finance_q15_answer;
        $this->finance_q15_comment = $this->financeAudit->finance_q15_comment;
        $this->finance_q16_answer = $this->financeAudit->finance_q16_answer;
        $this->finance_q16_comment = $this->financeAudit->finance_q16_comment;
        $this->finance_q17_answer = $this->financeAudit->finance_q17_answer;
        $this->finance_q17_comment = $this->financeAudit->finance_q17_comment;
        $this->finance_q18_answer = $this->financeAudit->finance_q18_answer;
        $this->finance_q18_comment = $this->financeAudit->finance_q18_comment;
        $this->finance_q19_answer = $this->financeAudit->finance_q19_answer;
        $this->finance_q19_comment = $this->financeAudit->finance_q19_comment;
        $this->finance_q20_answer = $this->financeAudit->finance_q20_answer;
        $this->finance_q20_comment = $this->financeAudit->finance_q20_comment;
        $this->finance_q21_answer = $this->financeAudit->finance_q21_answer;
        $this->finance_q21_comment = $this->financeAudit->finance_q21_comment;
        $this->finance_q22_answer = $this->financeAudit->finance_q22_answer;
        $this->finance_q22_comment = $this->financeAudit->finance_q22_comment;
        $this->finance_q23_answer = $this->financeAudit->finance_q23_answer;
        $this->finance_q23_comment = $this->financeAudit->finance_q23_comment;
        $this->finance_q24_answer = $this->financeAudit->finance_q24_answer;
        $this->finance_q24_comment = $this->financeAudit->finance_q24_comment;
        $this->finance_q25_answer = $this->financeAudit->finance_q25_answer;
        $this->finance_q25_comment = $this->financeAudit->finance_q25_comment;
        $this->finance_q26_answer = $this->financeAudit->finance_q26_answer;
        $this->finance_q26_comment = $this->financeAudit->finance_q26_comment;
        $this->finance_q27_answer = $this->financeAudit->finance_q27_answer;
        $this->finance_q27_comment = $this->financeAudit->finance_q27_comment;
        $this->finance_q28_answer = $this->financeAudit->finance_q28_answer;
        $this->finance_q28_comment = $this->financeAudit->finance_q28_comment;
        $this->finance_q29_answer = $this->financeAudit->finance_q29_answer;
        $this->finance_q29_comment = $this->financeAudit->finance_q29_comment;
        $this->finance_q30_answer = $this->financeAudit->finance_q30_answer;
        $this->finance_q30_comment = $this->financeAudit->finance_q30_comment;
        $this->finance_q31_answer = $this->financeAudit->finance_q31_answer;
        $this->finance_q31_comment = $this->financeAudit->finance_q31_comment;
        $this->finance_q32_answer = $this->financeAudit->finance_q32_answer;
        $this->finance_q32_comment = $this->financeAudit->finance_q32_comment;
        $this->finance_q33_answer = $this->financeAudit->finance_q33_answer;
        $this->finance_q33_comment = $this->financeAudit->finance_q33_comment;
        $this->finance_q34_answer = $this->financeAudit->finance_q34_answer;
        $this->finance_q34_comment = $this->financeAudit->finance_q34_comment;
        $this->finance_q35_answer = $this->financeAudit->finance_q35_answer;
        $this->finance_q35_comment = $this->financeAudit->finance_q35_comment;
        $this->finance_q36_answer = $this->financeAudit->finance_q36_answer;
        $this->finance_q36_comment = $this->financeAudit->finance_q36_comment;
        $this->finance_q37_answer = $this->financeAudit->finance_q37_answer;
        $this->finance_q37_comment = $this->financeAudit->finance_q37_comment;
        $this->finance_q38_answer = $this->financeAudit->finance_q38_answer;
        $this->finance_q38_comment = $this->financeAudit->finance_q38_comment;
        $this->finance_q39_answer = $this->financeAudit->finance_q39_answer;
        $this->finance_q39_comment = $this->financeAudit->finance_q39_comment;
        $this->finance_q40_answer = $this->financeAudit->finance_q40_answer;
        $this->finance_q40_comment = $this->financeAudit->finance_q40_comment;
        $this->finance_q41_answer = $this->financeAudit->finance_q41_answer;
        $this->finance_q41_comment = $this->financeAudit->finance_q41_comment;
        $this->finance_q42_answer = $this->financeAudit->finance_q42_answer;
        $this->finance_q42_comment = $this->financeAudit->finance_q42_comment;
        $this->finance_q43_answer = $this->financeAudit->finance_q43_answer;
        $this->finance_q43_comment = $this->financeAudit->finance_q43_comment;
        $this->finance_q44_answer = $this->financeAudit->finance_q44_answer;
        $this->finance_q44_comment = $this->financeAudit->finance_q44_comment;
        $this->finance_q45_answer = $this->financeAudit->finance_q45_answer;
        $this->finance_q45_comment = $this->financeAudit->finance_q45_comment;
        $this->finance_q46_answer = $this->financeAudit->finance_q46_answer;
        $this->finance_q46_comment = $this->financeAudit->finance_q46_comment;
        $this->finance_q47_answer = $this->financeAudit->finance_q47_answer;
        $this->finance_q47_comment = $this->financeAudit->finance_q47_comment;
        $this->finance_q48_answer = $this->financeAudit->finance_q48_answer;
        $this->finance_q48_comment = $this->financeAudit->finance_q48_comment;
        $this->finance_q49_answer = $this->financeAudit->finance_q49_answer;
        $this->finance_q49_comment = $this->financeAudit->finance_q49_comment;
    }

    public function update()
    {
        $this->validate();

        $this->financeAudit->update([
            'draft' => $this->draft,
            'finance_q1_answer' => $this->finance_q1_answer,
            'finance_q1_comment' => $this->finance_q1_comment,
            'finance_q2_answer' => $this->finance_q2_answer,
            'finance_q2_comment' => $this->finance_q2_comment,
            'finance_q3_answer' => $this->finance_q3_answer,
            'finance_q3_comment' => $this->finance_q3_comment,
            'finance_q4_answer' => $this->finance_q4_answer,
            'finance_q4_comment' => $this->finance_q4_comment,
            'finance_q5_answer' => $this->finance_q5_answer,
            'finance_q5_comment' => $this->finance_q5_comment,
            'finance_q6_answer' => $this->finance_q6_answer,
            'finance_q6_comment' => $this->finance_q6_comment,
            'finance_q7_answer' => $this->finance_q7_answer,
            'finance_q7_comment' => $this->finance_q7_comment,
            'finance_q8_answer' => $this->finance_q8_answer,
            'finance_q8_comment' => $this->finance_q8_comment,
            'finance_q9_answer' => $this->finance_q9_answer,
            'finance_q9_comment' => $this->finance_q9_comment,
            'finance_q10_answer' => $this->finance_q10_answer,
            'finance_q10_comment' => $this->finance_q10_comment,
            'finance_q11_answer' => $this->finance_q11_answer,
            'finance_q11_comment' => $this->finance_q11_comment,
            'finance_q12_answer' => $this->finance_q12_answer,
            'finance_q12_comment' => $this->finance_q12_comment,
            'finance_q13_answer' => $this->finance_q13_answer,
            'finance_q13_comment' => $this->finance_q13_comment,
            'finance_q14_answer' => $this->finance_q14_answer,
            'finance_q14_comment' => $this->finance_q14_comment,
            'finance_q15_answer' => $this->finance_q15_answer,
            'finance_q15_comment' => $this->finance_q15_comment,
            'finance_q16_answer' => $this->finance_q16_answer,
            'finance_q16_comment' => $this->finance_q16_comment,
            'finance_q17_answer' => $this->finance_q17_answer,
            'finance_q17_comment' => $this->finance_q17_comment,
            'finance_q18_answer' => $this->finance_q18_answer,
            'finance_q18_comment' => $this->finance_q18_comment,
            'finance_q19_answer' => $this->finance_q19_answer,
            'finance_q19_comment' => $this->finance_q19_comment,
            'finance_q20_answer' => $this->finance_q20_answer,
            'finance_q20_comment' => $this->finance_q20_comment,
            'finance_q21_answer' => $this->finance_q21_answer,
            'finance_q21_comment' => $this->finance_q21_comment,
            'finance_q22_answer' => $this->finance_q22_answer,
            'finance_q22_comment' => $this->finance_q22_comment,
            'finance_q23_answer' => $this->finance_q23_answer,
            'finance_q23_comment' => $this->finance_q23_comment,
            'finance_q24_answer' => $this->finance_q24_answer,
            'finance_q24_comment' => $this->finance_q24_comment,
            'finance_q25_answer' => $this->finance_q25_answer,
            'finance_q25_comment' => $this->finance_q25_comment,
            'finance_q26_answer' => $this->finance_q26_answer,
            'finance_q26_comment' => $this->finance_q26_comment,
            'finance_q27_answer' => $this->finance_q27_answer,
            'finance_q27_comment' => $this->finance_q27_comment,
            'finance_q28_answer' => $this->finance_q28_answer,
            'finance_q28_comment' => $this->finance_q28_comment,
            'finance_q29_answer' => $this->finance_q29_answer,
            'finance_q29_comment' => $this->finance_q29_comment,
            'finance_q30_answer' => $this->finance_q30_answer,
            'finance_q30_comment' => $this->finance_q30_comment,
            'finance_q31_answer' => $this->finance_q31_answer,
            'finance_q31_comment' => $this->finance_q31_comment,
            'finance_q32_answer' => $this->finance_q32_answer,
            'finance_q32_comment' => $this->finance_q32_comment,
            'finance_q33_answer' => $this->finance_q33_answer,
            'finance_q33_comment' => $this->finance_q33_comment,
            'finance_q34_answer' => $this->finance_q34_answer,
            'finance_q34_comment' => $this->finance_q34_comment,
            'finance_q35_answer' => $this->finance_q35_answer,
            'finance_q35_comment' => $this->finance_q35_comment,
            'finance_q36_answer' => $this->finance_q36_answer,
            'finance_q36_comment' => $this->finance_q36_comment,
            'finance_q37_answer' => $this->finance_q37_answer,
            'finance_q37_comment' => $this->finance_q37_comment,
            'finance_q38_answer' => $this->finance_q38_answer,
            'finance_q38_comment' => $this->finance_q38_comment,
            'finance_q39_answer' => $this->finance_q39_answer,
            'finance_q39_comment' => $this->finance_q39_comment,
            'finance_q40_answer' => $this->finance_q40_answer,
            'finance_q40_comment' => $this->finance_q40_comment,
            'finance_q41_answer' => $this->finance_q41_answer,
            'finance_q41_comment' => $this->finance_q41_comment,
            'finance_q42_answer' => $this->finance_q42_answer,
            'finance_q42_comment' => $this->finance_q42_comment,
            'finance_q43_answer' => $this->finance_q43_answer,
            'finance_q43_comment' => $this->finance_q43_comment,
            'finance_q44_answer' => $this->finance_q44_answer,
            'finance_q44_comment' => $this->finance_q44_comment,
            'finance_q45_answer' => $this->finance_q45_answer,
            'finance_q45_comment' => $this->finance_q45_comment,
            'finance_q46_answer' => $this->finance_q46_answer,
            'finance_q46_comment' => $this->finance_q46_comment,
            'finance_q47_answer' => $this->finance_q47_answer,
            'finance_q47_comment' => $this->finance_q47_comment,
            'finance_q48_answer' => $this->finance_q48_answer,
            'finance_q48_comment' => $this->finance_q48_comment,
            'finance_q49_answer' => $this->finance_q49_answer,
            'finance_q49_comment' => $this->finance_q49_comment
        ]);

        for ($i = 1; $i <= 49; $i++) {
            $this->financeAudit->syncFromMediaLibraryRequest($this->{'finance_q' . $i . '_images'})
                ->toMediaCollection('finance_q' . $i . '_images');
        }

        Notification::make()
            ->title('Finance Audit Updated Successfully!')
            ->success()
            ->send();

        if (tenant('locations')) {
            return redirect(route('dealer.stores.audits.finance.index', $this->store));
        } else {
            return redirect(route('dealer.audit.finance.index'));
        }
    }
    public function render()
    {
        return view('livewire.dealer.audit.finance.show');
    }
}
