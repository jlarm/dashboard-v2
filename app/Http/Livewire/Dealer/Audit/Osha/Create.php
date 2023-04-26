<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Create extends Component
{
    use WithMedia;

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
        'osha_q49_images',
        'osha_q50_images',
        'osha_q51_images',
        'osha_q52_images',
        'osha_q53_images',
        'osha_q54_images',
        'osha_q55_images',
        'osha_q56_images',
        'osha_q57_images',
        'osha_q58_images',
        'osha_q59_images',
        'osha_q60_images',
        'osha_q61_images',
        'osha_q62_images',
        'osha_q63_images',
        'osha_q64_images',
        'osha_q65_images',
        'osha_q66_images',
        'osha_q67_images',
        'osha_q68_images',
        'osha_q69_images',
    ];
    public $draft = false;
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
    public $osha_q50_answer;
    public $osha_q50_comment;
    public $osha_q50_images;
    public $osha_q51_answer;
    public $osha_q51_comment;
    public $osha_q51_images;
    public $osha_q52_answer;
    public $osha_q52_comment;
    public $osha_q52_images;
    public $osha_q53_answer;
    public $osha_q53_comment;
    public $osha_q53_images;
    public $osha_q54_answer;
    public $osha_q54_comment;
    public $osha_q54_images;
    public $osha_q55_answer;
    public $osha_q55_comment;
    public $osha_q55_images;
    public $osha_q56_answer;
    public $osha_q56_comment;
    public $osha_q56_images;
    public $osha_q57_answer;
    public $osha_q57_comment;
    public $osha_q57_images;
    public $osha_q58_answer;
    public $osha_q58_comment;
    public $osha_q58_images;
    public $osha_q59_answer;
    public $osha_q59_comment;
    public $osha_q59_images;
    public $osha_q60_answer;
    public $osha_q60_comment;
    public $osha_q60_images;
    public $osha_q61_answer;
    public $osha_q61_comment;
    public $osha_q61_images;
    public $osha_q62_answer;
    public $osha_q62_comment;
    public $osha_q62_images;
    public $osha_q63_answer;
    public $osha_q63_comment;
    public $osha_q63_images;
    public $osha_q64_answer;
    public $osha_q64_comment;
    public $osha_q64_images;
    public $osha_q65_answer;
    public $osha_q65_comment;
    public $osha_q65_images;
    public $osha_q66_answer;
    public $osha_q66_comment;
    public $osha_q66_images;
    public $osha_q67_answer;
    public $osha_q67_comment;
    public $osha_q67_images;
    public $osha_q68_answer;
    public $osha_q68_comment;
    public $osha_q68_images;
    public $osha_q69_answer;
    public $osha_q69_comment;
    public $osha_q69_images;

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
        'osha_q49_images' => 'nullable',
        'osha_q50_answer' => 'nullable',
        'osha_q50_comment' => 'nullable',
        'osha_q50_images' => 'nullable',
        'osha_q51_answer' => 'nullable',
        'osha_q51_comment' => 'nullable',
        'osha_q51_images' => 'nullable',
        'osha_q52_answer' => 'nullable',
        'osha_q52_comment' => 'nullable',
        'osha_q52_images' => 'nullable',
        'osha_q53_answer' => 'nullable',
        'osha_q53_comment' => 'nullable',
        'osha_q53_images' => 'nullable',
        'osha_q54_answer' => 'nullable',
        'osha_q54_comment' => 'nullable',
        'osha_q54_images' => 'nullable',
        'osha_q55_answer' => 'nullable',
        'osha_q55_comment' => 'nullable',
        'osha_q55_images' => 'nullable',
        'osha_q56_answer' => 'nullable',
        'osha_q56_comment' => 'nullable',
        'osha_q56_images' => 'nullable',
        'osha_q57_answer' => 'nullable',
        'osha_q57_comment' => 'nullable',
        'osha_q57_images' => 'nullable',
        'osha_q58_answer' => 'nullable',
        'osha_q58_comment' => 'nullable',
        'osha_q58_images' => 'nullable',
        'osha_q59_answer' => 'nullable',
        'osha_q59_comment' => 'nullable',
        'osha_q59_images' => 'nullable',
        'osha_q60_answer' => 'nullable',
        'osha_q60_comment' => 'nullable',
        'osha_q60_images' => 'nullable',
        'osha_q61_answer' => 'nullable',
        'osha_q61_comment' => 'nullable',
        'osha_q61_images' => 'nullable',
        'osha_q62_answer' => 'nullable',
        'osha_q62_comment' => 'nullable',
        'osha_q62_images' => 'nullable',
        'osha_q63_answer' => 'nullable',
        'osha_q63_comment' => 'nullable',
        'osha_q63_images' => 'nullable',
        'osha_q64_answer' => 'nullable',
        'osha_q64_comment' => 'nullable',
        'osha_q64_images' => 'nullable',
        'osha_q65_answer' => 'nullable',
        'osha_q65_comment' => 'nullable',
        'osha_q65_images' => 'nullable',
        'osha_q66_answer' => 'nullable',
        'osha_q66_comment' => 'nullable',
        'osha_q66_images' => 'nullable',
        'osha_q67_answer' => 'nullable',
        'osha_q67_comment' => 'nullable',
        'osha_q67_images' => 'nullable',
        'osha_q68_answer' => 'nullable',
        'osha_q68_comment' => 'nullable',
        'osha_q68_images' => 'nullable',
        'osha_q69_answer' => 'nullable',
        'osha_q69_comment' => 'nullable',
        'osha_q69_images' => 'nullable',
    ];

    public function submit()
    {
        $validated = $this->validate();

        $submission = OshaAudit::create($validated);

        for ($i = 1; $i <= 69; $i++) {
            $submission->addFromMediaLibraryRequest($this->{'osha_q' . $i . '_images'})
                ->toMediaCollection('osha_q' . $i . '_images');
        }

        return redirect(route('dealer.audit.osha.index'));
    }
    public function render()
    {
        return view('livewire.dealer.audit.osha.create');
    }
}
