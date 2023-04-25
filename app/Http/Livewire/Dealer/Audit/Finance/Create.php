<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Create extends Component
{
    use WithMedia;

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

    public $draft = false;
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

    public function submit()
    {
        $validated = $this->validate();

        $submission = FinanceAudit::create($validated);

        for ($i = 1; $i <= 69; $i++) {
            $submission->addFromMediaLibraryRequest($this->{'finance_q' . $i . '_images'})
                ->toMediaCollection('finance_q' . $i . '_images');
        }

        return redirect(route('dealer.audit.index'));
    }
    public function render()
    {
        return view('livewire.dealer.audit.finance.create');
    }
}
