<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Show extends Component
{
    use WithMedia;

    public FinanceAudit $audit;

    public $mediaComponentNames = [
        'osha_q1_images',
        'osha_q2_images',
        'osha_q3_images',
        'osha_q4_images',
        'osha_q5_images',
        'osha_q6_images',
        'osha_q7_images',
        'osha_q8_images',
        'osha_q9_images',
        'osha_q10_images',
        'osha_q11_images',
        'osha_q12_images',
        'osha_q13_images',
        'osha_q14_images',
        'osha_q15_images',
        'osha_q16_images',
        'osha_q17_images',
        'osha_q18_images',
        'osha_q19_images',
        'osha_q20_images',
        'osha_q21_images',
        'osha_q22_images',
        'osha_q23_images',
        'osha_q24_images',
        'osha_q25_images',
        'osha_q26_images',
        'osha_q27_images',
        'osha_q28_images',
        'osha_q29_images',
        'osha_q30_images',
        'osha_q31_images',
        'osha_q32_images',
        'osha_q33_images',
        'osha_q34_images',
        'osha_q35_images',
        'osha_q36_images',
        'osha_q37_images',
        'osha_q38_images',
        'osha_q39_images',
        'osha_q40_images',
        'osha_q41_images',
        'osha_q42_images',
        'osha_q43_images',
        'osha_q44_images',
        'osha_q45_images',
        'osha_q46_images',
        'osha_q47_images',
        'osha_q48_images',
        'osha_q49_images'
    ];

    public $draft;
    public $osha_q1_answer;
    public $osha_q1_comment;
    public $osha_q1_images;
    public $osha_q2_answer;
    public $osha_q2_comment;
    public $osha_q2_images;
    public $osha_q3_answer;
    public $osha_q3_comment;
    public $osha_q3_images;
    public $osha_q4_answer;
    public $osha_q4_comment;
    public $osha_q4_images;
    public $osha_q5_answer;
    public $osha_q5_comment;
    public $osha_q5_images;
    public $osha_q6_answer;
    public $osha_q6_comment;
    public $osha_q6_images;
    public $osha_q7_answer;
    public $osha_q7_comment;
    public $osha_q7_images;
    public $osha_q8_answer;
    public $osha_q8_comment;
    public $osha_q8_images;
    public $osha_q9_answer;
    public $osha_q9_comment;
    public $osha_q9_images;
    public $osha_q10_answer;
    public $osha_q10_comment;
    public $osha_q10_images;
    public $osha_q11_answer;
    public $osha_q11_comment;
    public $osha_q11_images;
    public $osha_q12_answer;
    public $osha_q12_comment;
    public $osha_q12_images;
    public $osha_q13_answer;
    public $osha_q13_comment;
    public $osha_q13_images;
    public $osha_q14_answer;
    public $osha_q14_comment;
    public $osha_q14_images;
    public $osha_q15_answer;
    public $osha_q15_comment;
    public $osha_q15_images;
    public $osha_q16_answer;
    public $osha_q16_comment;
    public $osha_q16_images;
    public $osha_q17_answer;
    public $osha_q17_comment;
    public $osha_q17_images;
    public $osha_q18_answer;
    public $osha_q18_comment;
    public $osha_q18_images;
    public $osha_q19_answer;
    public $osha_q19_comment;
    public $osha_q19_images;
    public $osha_q20_answer;
    public $osha_q20_comment;
    public $osha_q20_images;
    public $osha_q21_answer;
    public $osha_q21_comment;
    public $osha_q21_images;
    public $osha_q22_answer;
    public $osha_q22_comment;
    public $osha_q22_images;
    public $osha_q23_answer;
    public $osha_q23_comment;
    public $osha_q23_images;
    public $osha_q24_answer;
    public $osha_q24_comment;
    public $osha_q24_images;
    public $osha_q25_answer;
    public $osha_q25_comment;
    public $osha_q25_images;
    public $osha_q26_answer;
    public $osha_q26_comment;
    public $osha_q26_images;
    public $osha_q27_answer;
    public $osha_q27_comment;
    public $osha_q27_images;
    public $osha_q28_answer;
    public $osha_q28_comment;
    public $osha_q28_images;
    public $osha_q29_answer;
    public $osha_q29_comment;
    public $osha_q29_images;
    public $osha_q30_answer;
    public $osha_q30_comment;
    public $osha_q30_images;
    public $osha_q31_answer;
    public $osha_q31_comment;
    public $osha_q31_images;
    public $osha_q32_answer;
    public $osha_q32_comment;
    public $osha_q32_images;
    public $osha_q33_answer;
    public $osha_q33_comment;
    public $osha_q33_images;
    public $osha_q34_answer;
    public $osha_q34_comment;
    public $osha_q34_images;
    public $osha_q35_answer;
    public $osha_q35_comment;
    public $osha_q35_images;
    public $osha_q36_answer;
    public $osha_q36_comment;
    public $osha_q36_images;
    public $osha_q37_answer;
    public $osha_q37_comment;
    public $osha_q37_images;
    public $osha_q38_answer;
    public $osha_q38_comment;
    public $osha_q38_images;
    public $osha_q39_answer;
    public $osha_q39_comment;
    public $osha_q39_images;
    public $osha_q40_answer;
    public $osha_q40_comment;
    public $osha_q40_images;
    public $osha_q41_answer;
    public $osha_q41_comment;
    public $osha_q41_images;
    public $osha_q42_answer;
    public $osha_q42_comment;
    public $osha_q42_images;
    public $osha_q43_answer;
    public $osha_q43_comment;
    public $osha_q43_images;
    public $osha_q44_answer;
    public $osha_q44_comment;
    public $osha_q44_images;
    public $osha_q45_answer;
    public $osha_q45_comment;
    public $osha_q45_images;
    public $osha_q46_answer;
    public $osha_q46_comment;
    public $osha_q46_images;
    public $osha_q47_answer;
    public $osha_q47_comment;
    public $osha_q47_images;
    public $osha_q48_answer;
    public $osha_q48_comment;
    public $osha_q48_images;
    public $osha_q49_answer;
    public $osha_q49_comment;
    public $osha_q49_images;

    protected $rules = [
        'draft' => 'nullable',
        'osha_q1_answer' => 'nullable',
        'osha_q1_comment' => 'nullable',
        'osha_q1_images' => 'nullable',
        'osha_q2_answer' => 'nullable',
        'osha_q2_comment' => 'nullable',
        'osha_q2_images' => 'nullable',
        'osha_q3_answer' => 'nullable',
        'osha_q3_comment' => 'nullable',
        'osha_q3_images' => 'nullable',
        'osha_q4_answer' => 'nullable',
        'osha_q4_comment' => 'nullable',
        'osha_q4_images' => 'nullable',
        'osha_q5_answer' => 'nullable',
        'osha_q5_comment' => 'nullable',
        'osha_q5_images' => 'nullable',
        'osha_q6_answer' => 'nullable',
        'osha_q6_comment' => 'nullable',
        'osha_q6_images' => 'nullable',
        'osha_q7_answer' => 'nullable',
        'osha_q7_comment' => 'nullable',
        'osha_q7_images' => 'nullable',
        'osha_q8_answer' => 'nullable',
        'osha_q8_comment' => 'nullable',
        'osha_q8_images' => 'nullable',
        'osha_q9_answer' => 'nullable',
        'osha_q9_comment' => 'nullable',
        'osha_q9_images' => 'nullable',
        'osha_q10_answer' => 'nullable',
        'osha_q10_comment' => 'nullable',
        'osha_q10_images' => 'nullable',
        'osha_q11_answer' => 'nullable',
        'osha_q11_comment' => 'nullable',
        'osha_q11_images' => 'nullable',
        'osha_q12_answer' => 'nullable',
        'osha_q12_comment' => 'nullable',
        'osha_q12_images' => 'nullable',
        'osha_q13_answer' => 'nullable',
        'osha_q13_comment' => 'nullable',
        'osha_q13_images' => 'nullable',
        'osha_q14_answer' => 'nullable',
        'osha_q14_comment' => 'nullable',
        'osha_q14_images' => 'nullable',
        'osha_q15_answer' => 'nullable',
        'osha_q15_comment' => 'nullable',
        'osha_q15_images' => 'nullable',
        'osha_q16_answer' => 'nullable',
        'osha_q16_comment' => 'nullable',
        'osha_q16_images' => 'nullable',
        'osha_q17_answer' => 'nullable',
        'osha_q17_comment' => 'nullable',
        'osha_q17_images' => 'nullable',
        'osha_q18_answer' => 'nullable',
        'osha_q18_comment' => 'nullable',
        'osha_q18_images' => 'nullable',
        'osha_q19_answer' => 'nullable',
        'osha_q19_comment' => 'nullable',
        'osha_q19_images' => 'nullable',
        'osha_q20_answer' => 'nullable',
        'osha_q20_comment' => 'nullable',
        'osha_q20_images' => 'nullable',
        'osha_q21_answer' => 'nullable',
        'osha_q21_comment' => 'nullable',
        'osha_q21_images' => 'nullable',
        'osha_q22_answer' => 'nullable',
        'osha_q22_comment' => 'nullable',
        'osha_q22_images' => 'nullable',
        'osha_q23_answer' => 'nullable',
        'osha_q23_comment' => 'nullable',
        'osha_q23_images' => 'nullable',
        'osha_q24_answer' => 'nullable',
        'osha_q24_comment' => 'nullable',
        'osha_q24_images' => 'nullable',
        'osha_q25_answer' => 'nullable',
        'osha_q25_comment' => 'nullable',
        'osha_q25_images' => 'nullable',
        'osha_q26_answer' => 'nullable',
        'osha_q26_comment' => 'nullable',
        'osha_q26_images' => 'nullable',
        'osha_q27_answer' => 'nullable',
        'osha_q27_comment' => 'nullable',
        'osha_q27_images' => 'nullable',
        'osha_q28_answer' => 'nullable',
        'osha_q28_comment' => 'nullable',
        'osha_q28_images' => 'nullable',
        'osha_q29_answer' => 'nullable',
        'osha_q29_comment' => 'nullable',
        'osha_q29_images' => 'nullable',
        'osha_q30_answer' => 'nullable',
        'osha_q30_comment' => 'nullable',
        'osha_q30_images' => 'nullable',
        'osha_q31_answer' => 'nullable',
        'osha_q31_comment' => 'nullable',
        'osha_q31_images' => 'nullable',
        'osha_q32_answer' => 'nullable',
        'osha_q32_comment' => 'nullable',
        'osha_q32_images' => 'nullable',
        'osha_q33_answer' => 'nullable',
        'osha_q33_comment' => 'nullable',
        'osha_q33_images' => 'nullable',
        'osha_q34_answer' => 'nullable',
        'osha_q34_comment' => 'nullable',
        'osha_q34_images' => 'nullable',
        'osha_q35_answer' => 'nullable',
        'osha_q35_comment' => 'nullable',
        'osha_q35_images' => 'nullable',
        'osha_q36_answer' => 'nullable',
        'osha_q36_comment' => 'nullable',
        'osha_q36_images' => 'nullable',
        'osha_q37_answer' => 'nullable',
        'osha_q37_comment' => 'nullable',
        'osha_q37_images' => 'nullable',
        'osha_q38_answer' => 'nullable',
        'osha_q38_comment' => 'nullable',
        'osha_q38_images' => 'nullable',
        'osha_q39_answer' => 'nullable',
        'osha_q39_comment' => 'nullable',
        'osha_q39_images' => 'nullable',
        'osha_q40_answer' => 'nullable',
        'osha_q40_comment' => 'nullable',
        'osha_q40_images' => 'nullable',
        'osha_q41_answer' => 'nullable',
        'osha_q41_comment' => 'nullable',
        'osha_q41_images' => 'nullable',
        'osha_q42_answer' => 'nullable',
        'osha_q42_comment' => 'nullable',
        'osha_q42_images' => 'nullable',
        'osha_q43_answer' => 'nullable',
        'osha_q43_comment' => 'nullable',
        'osha_q43_images' => 'nullable',
        'osha_q44_answer' => 'nullable',
        'osha_q44_comment' => 'nullable',
        'osha_q44_images' => 'nullable',
        'osha_q45_answer' => 'nullable',
        'osha_q45_comment' => 'nullable',
        'osha_q45_images' => 'nullable',
        'osha_q46_answer' => 'nullable',
        'osha_q46_comment' => 'nullable',
        'osha_q46_images' => 'nullable',
        'osha_q47_answer' => 'nullable',
        'osha_q47_comment' => 'nullable',
        'osha_q47_images' => 'nullable',
        'osha_q48_answer' => 'nullable',
        'osha_q48_comment' => 'nullable',
        'osha_q48_images' => 'nullable',
        'osha_q49_answer' => 'nullable',
        'osha_q49_comment' => 'nullable',
        'osha_q49_images' => 'nullable'
    ];

    public function mount()
    {
        $this->draft = $this->audit->draft;
        $this->osha_q1_answer = $this->audit->osha_q1_answer;
        $this->osha_q1_comment = $this->audit->osha_q1_comment;
        $this->osha_q2_answer = $this->audit->osha_q2_answer;
        $this->osha_q2_comment = $this->audit->osha_q2_comment;
        $this->osha_q3_answer = $this->audit->osha_q3_answer;
        $this->osha_q3_comment = $this->audit->osha_q3_comment;
        $this->osha_q4_answer = $this->audit->osha_q4_answer;
        $this->osha_q4_comment = $this->audit->osha_q4_comment;
        $this->osha_q5_answer = $this->audit->osha_q5_answer;
        $this->osha_q5_comment = $this->audit->osha_q5_comment;
        $this->osha_q6_answer = $this->audit->osha_q6_answer;
        $this->osha_q6_comment = $this->audit->osha_q6_comment;
        $this->osha_q7_answer = $this->audit->osha_q7_answer;
        $this->osha_q7_comment = $this->audit->osha_q7_comment;
        $this->osha_q8_answer = $this->audit->osha_q8_answer;
        $this->osha_q8_comment = $this->audit->osha_q8_comment;
        $this->osha_q9_answer = $this->audit->osha_q9_answer;
        $this->osha_q9_comment = $this->audit->osha_q9_comment;
        $this->osha_q10_answer = $this->audit->osha_q10_answer;
        $this->osha_q10_comment = $this->audit->osha_q10_comment;
        $this->osha_q11_answer = $this->audit->osha_q11_answer;
        $this->osha_q11_comment = $this->audit->osha_q11_comment;
        $this->osha_q12_answer = $this->audit->osha_q12_answer;
        $this->osha_q12_comment = $this->audit->osha_q12_comment;
        $this->osha_q13_answer = $this->audit->osha_q13_answer;
        $this->osha_q13_comment = $this->audit->osha_q13_comment;
        $this->osha_q14_answer = $this->audit->osha_q14_answer;
        $this->osha_q14_comment = $this->audit->osha_q14_comment;
        $this->osha_q15_answer = $this->audit->osha_q15_answer;
        $this->osha_q15_comment = $this->audit->osha_q15_comment;
        $this->osha_q16_answer = $this->audit->osha_q16_answer;
        $this->osha_q16_comment = $this->audit->osha_q16_comment;
        $this->osha_q17_answer = $this->audit->osha_q17_answer;
        $this->osha_q17_comment = $this->audit->osha_q17_comment;
        $this->osha_q18_answer = $this->audit->osha_q18_answer;
        $this->osha_q18_comment = $this->audit->osha_q18_comment;
        $this->osha_q19_answer = $this->audit->osha_q19_answer;
        $this->osha_q19_comment = $this->audit->osha_q19_comment;
        $this->osha_q20_answer = $this->audit->osha_q20_answer;
        $this->osha_q20_comment = $this->audit->osha_q20_comment;
        $this->osha_q21_answer = $this->audit->osha_q21_answer;
        $this->osha_q21_comment = $this->audit->osha_q21_comment;
        $this->osha_q22_answer = $this->audit->osha_q22_answer;
        $this->osha_q22_comment = $this->audit->osha_q22_comment;
        $this->osha_q23_answer = $this->audit->osha_q23_answer;
        $this->osha_q23_comment = $this->audit->osha_q23_comment;
        $this->osha_q24_answer = $this->audit->osha_q24_answer;
        $this->osha_q24_comment = $this->audit->osha_q24_comment;
        $this->osha_q25_answer = $this->audit->osha_q25_answer;
        $this->osha_q25_comment = $this->audit->osha_q25_comment;
        $this->osha_q26_answer = $this->audit->osha_q26_answer;
        $this->osha_q26_comment = $this->audit->osha_q26_comment;
        $this->osha_q27_answer = $this->audit->osha_q27_answer;
        $this->osha_q27_comment = $this->audit->osha_q27_comment;
        $this->osha_q28_answer = $this->audit->osha_q28_answer;
        $this->osha_q28_comment = $this->audit->osha_q28_comment;
        $this->osha_q29_answer = $this->audit->osha_q29_answer;
        $this->osha_q29_comment = $this->audit->osha_q29_comment;
        $this->osha_q30_answer = $this->audit->osha_q30_answer;
        $this->osha_q30_comment = $this->audit->osha_q30_comment;
        $this->osha_q31_answer = $this->audit->osha_q31_answer;
        $this->osha_q31_comment = $this->audit->osha_q31_comment;
        $this->osha_q32_answer = $this->audit->osha_q32_answer;
        $this->osha_q32_comment = $this->audit->osha_q32_comment;
        $this->osha_q33_answer = $this->audit->osha_q33_answer;
        $this->osha_q33_comment = $this->audit->osha_q33_comment;
        $this->osha_q34_answer = $this->audit->osha_q34_answer;
        $this->osha_q34_comment = $this->audit->osha_q34_comment;
        $this->osha_q35_answer = $this->audit->osha_q35_answer;
        $this->osha_q35_comment = $this->audit->osha_q35_comment;
        $this->osha_q36_answer = $this->audit->osha_q36_answer;
        $this->osha_q36_comment = $this->audit->osha_q36_comment;
        $this->osha_q37_answer = $this->audit->osha_q37_answer;
        $this->osha_q37_comment = $this->audit->osha_q37_comment;
        $this->osha_q38_answer = $this->audit->osha_q38_answer;
        $this->osha_q38_comment = $this->audit->osha_q38_comment;
        $this->osha_q39_answer = $this->audit->osha_q39_answer;
        $this->osha_q39_comment = $this->audit->osha_q39_comment;
        $this->osha_q40_answer = $this->audit->osha_q40_answer;
        $this->osha_q40_comment = $this->audit->osha_q40_comment;
        $this->osha_q41_answer = $this->audit->osha_q41_answer;
        $this->osha_q41_comment = $this->audit->osha_q41_comment;
        $this->osha_q42_answer = $this->audit->osha_q42_answer;
        $this->osha_q42_comment = $this->audit->osha_q42_comment;
        $this->osha_q43_answer = $this->audit->osha_q43_answer;
        $this->osha_q43_comment = $this->audit->osha_q43_comment;
        $this->osha_q44_answer = $this->audit->osha_q44_answer;
        $this->osha_q44_comment = $this->audit->osha_q44_comment;
        $this->osha_q45_answer = $this->audit->osha_q45_answer;
        $this->osha_q45_comment = $this->audit->osha_q45_comment;
        $this->osha_q46_answer = $this->audit->osha_q46_answer;
        $this->osha_q46_comment = $this->audit->osha_q46_comment;
        $this->osha_q47_answer = $this->audit->osha_q47_answer;
        $this->osha_q47_comment = $this->audit->osha_q47_comment;
        $this->osha_q48_answer = $this->audit->osha_q48_answer;
        $this->osha_q48_comment = $this->audit->osha_q48_comment;
        $this->osha_q49_answer = $this->audit->osha_q49_answer;
        $this->osha_q49_comment = $this->audit->osha_q49_comment;
    }

    public function update()
    {
        $this->validate();

        $this->audit->update([
            'draft' => $this->draft,
            'osha_q1_answer' => $this->osha_q1_answer,
            'osha_q1_comment' => $this->osha_q1_comment,
            'osha_q2_answer' => $this->osha_q2_answer,
            'osha_q2_comment' => $this->osha_q2_comment,
            'osha_q3_answer' => $this->osha_q3_answer,
            'osha_q3_comment' => $this->osha_q3_comment,
            'osha_q4_answer' => $this->osha_q4_answer,
            'osha_q4_comment' => $this->osha_q4_comment,
            'osha_q5_answer' => $this->osha_q5_answer,
            'osha_q5_comment' => $this->osha_q5_comment,
            'osha_q6_answer' => $this->osha_q6_answer,
            'osha_q6_comment' => $this->osha_q6_comment,
            'osha_q7_answer' => $this->osha_q7_answer,
            'osha_q7_comment' => $this->osha_q7_comment,
            'osha_q8_answer' => $this->osha_q8_answer,
            'osha_q8_comment' => $this->osha_q8_comment,
            'osha_q9_answer' => $this->osha_q9_answer,
            'osha_q9_comment' => $this->osha_q9_comment,
            'osha_q10_answer' => $this->osha_q10_answer,
            'osha_q10_comment' => $this->osha_q10_comment,
            'osha_q11_answer' => $this->osha_q11_answer,
            'osha_q11_comment' => $this->osha_q11_comment,
            'osha_q12_answer' => $this->osha_q12_answer,
            'osha_q12_comment' => $this->osha_q12_comment,
            'osha_q13_answer' => $this->osha_q13_answer,
            'osha_q13_comment' => $this->osha_q13_comment,
            'osha_q14_answer' => $this->osha_q14_answer,
            'osha_q14_comment' => $this->osha_q14_comment,
            'osha_q15_answer' => $this->osha_q15_answer,
            'osha_q15_comment' => $this->osha_q15_comment,
            'osha_q16_answer' => $this->osha_q16_answer,
            'osha_q16_comment' => $this->osha_q16_comment,
            'osha_q17_answer' => $this->osha_q17_answer,
            'osha_q17_comment' => $this->osha_q17_comment,
            'osha_q18_answer' => $this->osha_q18_answer,
            'osha_q18_comment' => $this->osha_q18_comment,
            'osha_q19_answer' => $this->osha_q19_answer,
            'osha_q19_comment' => $this->osha_q19_comment,
            'osha_q20_answer' => $this->osha_q20_answer,
            'osha_q20_comment' => $this->osha_q20_comment,
            'osha_q21_answer' => $this->osha_q21_answer,
            'osha_q21_comment' => $this->osha_q21_comment,
            'osha_q22_answer' => $this->osha_q22_answer,
            'osha_q22_comment' => $this->osha_q22_comment,
            'osha_q23_answer' => $this->osha_q23_answer,
            'osha_q23_comment' => $this->osha_q23_comment,
            'osha_q24_answer' => $this->osha_q24_answer,
            'osha_q24_comment' => $this->osha_q24_comment,
            'osha_q25_answer' => $this->osha_q25_answer,
            'osha_q25_comment' => $this->osha_q25_comment,
            'osha_q26_answer' => $this->osha_q26_answer,
            'osha_q26_comment' => $this->osha_q26_comment,
            'osha_q27_answer' => $this->osha_q27_answer,
            'osha_q27_comment' => $this->osha_q27_comment,
            'osha_q28_answer' => $this->osha_q28_answer,
            'osha_q28_comment' => $this->osha_q28_comment,
            'osha_q29_answer' => $this->osha_q29_answer,
            'osha_q29_comment' => $this->osha_q29_comment,
            'osha_q30_answer' => $this->osha_q30_answer,
            'osha_q30_comment' => $this->osha_q30_comment,
            'osha_q31_answer' => $this->osha_q31_answer,
            'osha_q31_comment' => $this->osha_q31_comment,
            'osha_q32_answer' => $this->osha_q32_answer,
            'osha_q32_comment' => $this->osha_q32_comment,
            'osha_q33_answer' => $this->osha_q33_answer,
            'osha_q33_comment' => $this->osha_q33_comment,
            'osha_q34_answer' => $this->osha_q34_answer,
            'osha_q34_comment' => $this->osha_q34_comment,
            'osha_q35_answer' => $this->osha_q35_answer,
            'osha_q35_comment' => $this->osha_q35_comment,
            'osha_q36_answer' => $this->osha_q36_answer,
            'osha_q36_comment' => $this->osha_q36_comment,
            'osha_q37_answer' => $this->osha_q37_answer,
            'osha_q37_comment' => $this->osha_q37_comment,
            'osha_q38_answer' => $this->osha_q38_answer,
            'osha_q38_comment' => $this->osha_q38_comment,
            'osha_q39_answer' => $this->osha_q39_answer,
            'osha_q39_comment' => $this->osha_q39_comment,
            'osha_q40_answer' => $this->osha_q40_answer,
            'osha_q40_comment' => $this->osha_q40_comment,
            'osha_q41_answer' => $this->osha_q41_answer,
            'osha_q41_comment' => $this->osha_q41_comment,
            'osha_q42_answer' => $this->osha_q42_answer,
            'osha_q42_comment' => $this->osha_q42_comment,
            'osha_q43_answer' => $this->osha_q43_answer,
            'osha_q43_comment' => $this->osha_q43_comment,
            'osha_q44_answer' => $this->osha_q44_answer,
            'osha_q44_comment' => $this->osha_q44_comment,
            'osha_q45_answer' => $this->osha_q45_answer,
            'osha_q45_comment' => $this->osha_q45_comment,
            'osha_q46_answer' => $this->osha_q46_answer,
            'osha_q46_comment' => $this->osha_q46_comment,
            'osha_q47_answer' => $this->osha_q47_answer,
            'osha_q47_comment' => $this->osha_q47_comment,
            'osha_q48_answer' => $this->osha_q48_answer,
            'osha_q48_comment' => $this->osha_q48_comment,
            'osha_q49_answer' => $this->osha_q49_answer,
            'osha_q49_comment' => $this->osha_q49_comment
        ]);

        for ($i = 1; $i <= 69; $i++) {
            $this->audit->syncFromMediaLibraryRequest($this->{'osha_q' . $i . '_images'})
                ->toMediaCollection('osha_q' . $i . '_images');
        }

        return redirect(route('dealer.audit.index'));
    }
    public function render()
    {
        return view('livewire.dealer.audit.finance.show');
    }
}
