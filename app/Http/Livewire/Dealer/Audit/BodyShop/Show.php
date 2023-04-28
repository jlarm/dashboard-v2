<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Show extends Component
{
    use WithMedia;
    public Store $store;
    public BodyShopAudit $bodyShopAudit;

    public $mediaComponentNames = [
        'body_shop_q1_images',
        'body_shop_q2_images',
        'body_shop_q3_images',
        'body_shop_q4_images',
        'body_shop_q5_images',
        'body_shop_q6_images',
        'body_shop_q7_images',
        'body_shop_q8_images',
        'body_shop_q9_images',
        'body_shop_q10_images',
        'body_shop_q11_images',
        'body_shop_q12_images',
        'body_shop_q13_images',
        'body_shop_q14_images',
        'body_shop_q15_images',
        'body_shop_q16_images',
        'body_shop_q17_images',
        'body_shop_q18_images',
        'body_shop_q19_images',
        'body_shop_q20_images',
        'body_shop_q21_images',
        'body_shop_q22_images',
        'body_shop_q23_images',
        'body_shop_q24_images',
        'body_shop_q25_images',
        'body_shop_q26_images',
        'body_shop_q27_images',
        'body_shop_q28_images',
        'body_shop_q29_images',
        'body_shop_q30_images',
        'body_shop_q31_images',
        'body_shop_q32_images',
        'body_shop_q33_images',
        'body_shop_q34_images',
        'body_shop_q35_images',
        'body_shop_q36_images',
        'body_shop_q37_images',
        'body_shop_q38_images',
        'body_shop_q39_images',
        'body_shop_q40_images',
        'body_shop_q41_images',
        'body_shop_q42_images',
        'body_shop_q43_images',
        'body_shop_q44_images',
        'body_shop_q45_images',
    ];

    public $draft;
    public $body_shop_q1_answer;
    public $body_shop_q1_comment;
    public $body_shop_q1_images;
    public $body_shop_q2_answer;
    public $body_shop_q2_comment;
    public $body_shop_q2_images;
    public $body_shop_q3_answer;
    public $body_shop_q3_comment;
    public $body_shop_q3_images;
    public $body_shop_q4_answer;
    public $body_shop_q4_comment;
    public $body_shop_q4_images;
    public $body_shop_q5_answer;
    public $body_shop_q5_comment;
    public $body_shop_q5_images;
    public $body_shop_q6_answer;
    public $body_shop_q6_comment;
    public $body_shop_q6_images;
    public $body_shop_q7_answer;
    public $body_shop_q7_comment;
    public $body_shop_q7_images;
    public $body_shop_q8_answer;
    public $body_shop_q8_comment;
    public $body_shop_q8_images;
    public $body_shop_q9_answer;
    public $body_shop_q9_comment;
    public $body_shop_q9_images;
    public $body_shop_q10_answer;
    public $body_shop_q10_comment;
    public $body_shop_q10_images;
    public $body_shop_q11_answer;
    public $body_shop_q11_comment;
    public $body_shop_q11_images;
    public $body_shop_q12_answer;
    public $body_shop_q12_comment;
    public $body_shop_q12_images;
    public $body_shop_q13_answer;
    public $body_shop_q13_comment;
    public $body_shop_q13_images;
    public $body_shop_q14_answer;
    public $body_shop_q14_comment;
    public $body_shop_q14_images;
    public $body_shop_q15_answer;
    public $body_shop_q15_comment;
    public $body_shop_q15_images;
    public $body_shop_q16_answer;
    public $body_shop_q16_comment;
    public $body_shop_q16_images;
    public $body_shop_q17_answer;
    public $body_shop_q17_comment;
    public $body_shop_q17_images;
    public $body_shop_q18_answer;
    public $body_shop_q18_comment;
    public $body_shop_q18_images;
    public $body_shop_q19_answer;
    public $body_shop_q19_comment;
    public $body_shop_q19_images;
    public $body_shop_q20_answer;
    public $body_shop_q20_comment;
    public $body_shop_q20_images;
    public $body_shop_q21_answer;
    public $body_shop_q21_comment;
    public $body_shop_q21_images;
    public $body_shop_q22_answer;
    public $body_shop_q22_comment;
    public $body_shop_q22_images;
    public $body_shop_q23_answer;
    public $body_shop_q23_comment;
    public $body_shop_q23_images;
    public $body_shop_q24_answer;
    public $body_shop_q24_comment;
    public $body_shop_q24_images;
    public $body_shop_q25_answer;
    public $body_shop_q25_comment;
    public $body_shop_q25_images;
    public $body_shop_q26_answer;
    public $body_shop_q26_comment;
    public $body_shop_q26_images;
    public $body_shop_q27_answer;
    public $body_shop_q27_comment;
    public $body_shop_q27_images;
    public $body_shop_q28_answer;
    public $body_shop_q28_comment;
    public $body_shop_q28_images;
    public $body_shop_q29_answer;
    public $body_shop_q29_comment;
    public $body_shop_q29_images;
    public $body_shop_q30_answer;
    public $body_shop_q30_comment;
    public $body_shop_q30_images;
    public $body_shop_q31_answer;
    public $body_shop_q31_comment;
    public $body_shop_q31_images;
    public $body_shop_q32_answer;
    public $body_shop_q32_comment;
    public $body_shop_q32_images;
    public $body_shop_q33_answer;
    public $body_shop_q33_comment;
    public $body_shop_q33_images;
    public $body_shop_q34_answer;
    public $body_shop_q34_comment;
    public $body_shop_q34_images;
    public $body_shop_q35_answer;
    public $body_shop_q35_comment;
    public $body_shop_q35_images;
    public $body_shop_q36_answer;
    public $body_shop_q36_comment;
    public $body_shop_q36_images;
    public $body_shop_q37_answer;
    public $body_shop_q37_comment;
    public $body_shop_q37_images;
    public $body_shop_q38_answer;
    public $body_shop_q38_comment;
    public $body_shop_q38_images;
    public $body_shop_q39_answer;
    public $body_shop_q39_comment;
    public $body_shop_q39_images;
    public $body_shop_q40_answer;
    public $body_shop_q40_comment;
    public $body_shop_q40_images;
    public $body_shop_q41_answer;
    public $body_shop_q41_comment;
    public $body_shop_q41_images;
    public $body_shop_q42_answer;
    public $body_shop_q42_comment;
    public $body_shop_q42_images;
    public $body_shop_q43_answer;
    public $body_shop_q43_comment;
    public $body_shop_q43_images;
    public $body_shop_q44_answer;
    public $body_shop_q44_comment;
    public $body_shop_q44_images;
    public $body_shop_q45_answer;
    public $body_shop_q45_comment;
    public $body_shop_q45_images;

    protected $rules = [
        'draft' => 'nullable',
        'body_shop_q1_answer' => 'nullable',
        'body_shop_q1_comment' => 'nullable',
        'body_shop_q1_images' => 'nullable',
        'body_shop_q2_answer' => 'nullable',
        'body_shop_q2_comment' => 'nullable',
        'body_shop_q2_images' => 'nullable',
        'body_shop_q3_answer' => 'nullable',
        'body_shop_q3_comment' => 'nullable',
        'body_shop_q3_images' => 'nullable',
        'body_shop_q4_answer' => 'nullable',
        'body_shop_q4_comment' => 'nullable',
        'body_shop_q4_images' => 'nullable',
        'body_shop_q5_answer' => 'nullable',
        'body_shop_q5_comment' => 'nullable',
        'body_shop_q5_images' => 'nullable',
        'body_shop_q6_answer' => 'nullable',
        'body_shop_q6_comment' => 'nullable',
        'body_shop_q6_images' => 'nullable',
        'body_shop_q7_answer' => 'nullable',
        'body_shop_q7_comment' => 'nullable',
        'body_shop_q7_images' => 'nullable',
        'body_shop_q8_answer' => 'nullable',
        'body_shop_q8_comment' => 'nullable',
        'body_shop_q8_images' => 'nullable',
        'body_shop_q9_answer' => 'nullable',
        'body_shop_q9_comment' => 'nullable',
        'body_shop_q9_images' => 'nullable',
        'body_shop_q10_answer' => 'nullable',
        'body_shop_q10_comment' => 'nullable',
        'body_shop_q10_images' => 'nullable',
        'body_shop_q11_answer' => 'nullable',
        'body_shop_q11_comment' => 'nullable',
        'body_shop_q11_images' => 'nullable',
        'body_shop_q12_answer' => 'nullable',
        'body_shop_q12_comment' => 'nullable',
        'body_shop_q12_images' => 'nullable',
        'body_shop_q13_answer' => 'nullable',
        'body_shop_q13_comment' => 'nullable',
        'body_shop_q13_images' => 'nullable',
        'body_shop_q14_answer' => 'nullable',
        'body_shop_q14_comment' => 'nullable',
        'body_shop_q14_images' => 'nullable',
        'body_shop_q15_answer' => 'nullable',
        'body_shop_q15_comment' => 'nullable',
        'body_shop_q15_images' => 'nullable',
        'body_shop_q16_answer' => 'nullable',
        'body_shop_q16_comment' => 'nullable',
        'body_shop_q16_images' => 'nullable',
        'body_shop_q17_answer' => 'nullable',
        'body_shop_q17_comment' => 'nullable',
        'body_shop_q17_images' => 'nullable',
        'body_shop_q18_answer' => 'nullable',
        'body_shop_q18_comment' => 'nullable',
        'body_shop_q18_images' => 'nullable',
        'body_shop_q19_answer' => 'nullable',
        'body_shop_q19_comment' => 'nullable',
        'body_shop_q19_images' => 'nullable',
        'body_shop_q20_answer' => 'nullable',
        'body_shop_q20_comment' => 'nullable',
        'body_shop_q20_images' => 'nullable',
        'body_shop_q21_answer' => 'nullable',
        'body_shop_q21_comment' => 'nullable',
        'body_shop_q21_images' => 'nullable',
        'body_shop_q22_answer' => 'nullable',
        'body_shop_q22_comment' => 'nullable',
        'body_shop_q22_images' => 'nullable',
        'body_shop_q23_answer' => 'nullable',
        'body_shop_q23_comment' => 'nullable',
        'body_shop_q23_images' => 'nullable',
        'body_shop_q24_answer' => 'nullable',
        'body_shop_q24_comment' => 'nullable',
        'body_shop_q24_images' => 'nullable',
        'body_shop_q25_answer' => 'nullable',
        'body_shop_q25_comment' => 'nullable',
        'body_shop_q25_images' => 'nullable',
        'body_shop_q26_answer' => 'nullable',
        'body_shop_q26_comment' => 'nullable',
        'body_shop_q26_images' => 'nullable',
        'body_shop_q27_answer' => 'nullable',
        'body_shop_q27_comment' => 'nullable',
        'body_shop_q27_images' => 'nullable',
        'body_shop_q28_answer' => 'nullable',
        'body_shop_q28_comment' => 'nullable',
        'body_shop_q28_images' => 'nullable',
        'body_shop_q29_answer' => 'nullable',
        'body_shop_q29_comment' => 'nullable',
        'body_shop_q29_images' => 'nullable',
        'body_shop_q30_answer' => 'nullable',
        'body_shop_q30_comment' => 'nullable',
        'body_shop_q30_images' => 'nullable',
        'body_shop_q31_answer' => 'nullable',
        'body_shop_q31_comment' => 'nullable',
        'body_shop_q31_images' => 'nullable',
        'body_shop_q32_answer' => 'nullable',
        'body_shop_q32_comment' => 'nullable',
        'body_shop_q32_images' => 'nullable',
        'body_shop_q33_answer' => 'nullable',
        'body_shop_q33_comment' => 'nullable',
        'body_shop_q33_images' => 'nullable',
        'body_shop_q34_answer' => 'nullable',
        'body_shop_q34_comment' => 'nullable',
        'body_shop_q34_images' => 'nullable',
        'body_shop_q35_answer' => 'nullable',
        'body_shop_q35_comment' => 'nullable',
        'body_shop_q35_images' => 'nullable',
        'body_shop_q36_answer' => 'nullable',
        'body_shop_q36_comment' => 'nullable',
        'body_shop_q36_images' => 'nullable',
        'body_shop_q37_answer' => 'nullable',
        'body_shop_q37_comment' => 'nullable',
        'body_shop_q37_images' => 'nullable',
        'body_shop_q38_answer' => 'nullable',
        'body_shop_q38_comment' => 'nullable',
        'body_shop_q38_images' => 'nullable',
        'body_shop_q39_answer' => 'nullable',
        'body_shop_q39_comment' => 'nullable',
        'body_shop_q39_images' => 'nullable',
        'body_shop_q40_answer' => 'nullable',
        'body_shop_q40_comment' => 'nullable',
        'body_shop_q40_images' => 'nullable',
        'body_shop_q41_answer' => 'nullable',
        'body_shop_q41_comment' => 'nullable',
        'body_shop_q41_images' => 'nullable',
        'body_shop_q42_answer' => 'nullable',
        'body_shop_q42_comment' => 'nullable',
        'body_shop_q42_images' => 'nullable',
        'body_shop_q43_answer' => 'nullable',
        'body_shop_q43_comment' => 'nullable',
        'body_shop_q43_images' => 'nullable',
        'body_shop_q44_answer' => 'nullable',
        'body_shop_q44_comment' => 'nullable',
        'body_shop_q44_images' => 'nullable',
        'body_shop_q45_answer' => 'nullable',
        'body_shop_q45_comment' => 'nullable',
        'body_shop_q45_images' => 'nullable'
    ];

    public function mount()
    {
        $this->draft = $this->bodyShopAudit->draft;
        $this->body_shop_q1_answer = $this->bodyShopAudit->body_shop_q1_answer;
        $this->body_shop_q1_comment = $this->bodyShopAudit->body_shop_q1_comment;
        $this->body_shop_q2_answer = $this->bodyShopAudit->body_shop_q2_answer;
        $this->body_shop_q2_comment = $this->bodyShopAudit->body_shop_q2_comment;
        $this->body_shop_q3_answer = $this->bodyShopAudit->body_shop_q3_answer;
        $this->body_shop_q3_comment = $this->bodyShopAudit->body_shop_q3_comment;
        $this->body_shop_q4_answer = $this->bodyShopAudit->body_shop_q4_answer;
        $this->body_shop_q4_comment = $this->bodyShopAudit->body_shop_q4_comment;
        $this->body_shop_q5_answer = $this->bodyShopAudit->body_shop_q5_answer;
        $this->body_shop_q5_comment = $this->bodyShopAudit->body_shop_q5_comment;
        $this->body_shop_q6_answer = $this->bodyShopAudit->body_shop_q6_answer;
        $this->body_shop_q6_comment = $this->bodyShopAudit->body_shop_q6_comment;
        $this->body_shop_q7_answer = $this->bodyShopAudit->body_shop_q7_answer;
        $this->body_shop_q7_comment = $this->bodyShopAudit->body_shop_q7_comment;
        $this->body_shop_q8_answer = $this->bodyShopAudit->body_shop_q8_answer;
        $this->body_shop_q8_comment = $this->bodyShopAudit->body_shop_q8_comment;
        $this->body_shop_q9_answer = $this->bodyShopAudit->body_shop_q9_answer;
        $this->body_shop_q9_comment = $this->bodyShopAudit->body_shop_q9_comment;
        $this->body_shop_q10_answer = $this->bodyShopAudit->body_shop_q10_answer;
        $this->body_shop_q10_comment = $this->bodyShopAudit->body_shop_q10_comment;
        $this->body_shop_q11_answer = $this->bodyShopAudit->body_shop_q11_answer;
        $this->body_shop_q11_comment = $this->bodyShopAudit->body_shop_q11_comment;
        $this->body_shop_q12_answer = $this->bodyShopAudit->body_shop_q12_answer;
        $this->body_shop_q12_comment = $this->bodyShopAudit->body_shop_q12_comment;
        $this->body_shop_q13_answer = $this->bodyShopAudit->body_shop_q13_answer;
        $this->body_shop_q13_comment = $this->bodyShopAudit->body_shop_q13_comment;
        $this->body_shop_q14_answer = $this->bodyShopAudit->body_shop_q14_answer;
        $this->body_shop_q14_comment = $this->bodyShopAudit->body_shop_q14_comment;
        $this->body_shop_q15_answer = $this->bodyShopAudit->body_shop_q15_answer;
        $this->body_shop_q15_comment = $this->bodyShopAudit->body_shop_q15_comment;
        $this->body_shop_q16_answer = $this->bodyShopAudit->body_shop_q16_answer;
        $this->body_shop_q16_comment = $this->bodyShopAudit->body_shop_q16_comment;
        $this->body_shop_q17_answer = $this->bodyShopAudit->body_shop_q17_answer;
        $this->body_shop_q17_comment = $this->bodyShopAudit->body_shop_q17_comment;
        $this->body_shop_q18_answer = $this->bodyShopAudit->body_shop_q18_answer;
        $this->body_shop_q18_comment = $this->bodyShopAudit->body_shop_q18_comment;
        $this->body_shop_q19_answer = $this->bodyShopAudit->body_shop_q19_answer;
        $this->body_shop_q19_comment = $this->bodyShopAudit->body_shop_q19_comment;
        $this->body_shop_q20_answer = $this->bodyShopAudit->body_shop_q20_answer;
        $this->body_shop_q20_comment = $this->bodyShopAudit->body_shop_q20_comment;
        $this->body_shop_q21_answer = $this->bodyShopAudit->body_shop_q21_answer;
        $this->body_shop_q21_comment = $this->bodyShopAudit->body_shop_q21_comment;
        $this->body_shop_q22_answer = $this->bodyShopAudit->body_shop_q22_answer;
        $this->body_shop_q22_comment = $this->bodyShopAudit->body_shop_q22_comment;
        $this->body_shop_q23_answer = $this->bodyShopAudit->body_shop_q23_answer;
        $this->body_shop_q23_comment = $this->bodyShopAudit->body_shop_q23_comment;
        $this->body_shop_q24_answer = $this->bodyShopAudit->body_shop_q24_answer;
        $this->body_shop_q24_comment = $this->bodyShopAudit->body_shop_q24_comment;
        $this->body_shop_q25_answer = $this->bodyShopAudit->body_shop_q25_answer;
        $this->body_shop_q25_comment = $this->bodyShopAudit->body_shop_q25_comment;
        $this->body_shop_q26_answer = $this->bodyShopAudit->body_shop_q26_answer;
        $this->body_shop_q26_comment = $this->bodyShopAudit->body_shop_q26_comment;
        $this->body_shop_q27_answer = $this->bodyShopAudit->body_shop_q27_answer;
        $this->body_shop_q27_comment = $this->bodyShopAudit->body_shop_q27_comment;
        $this->body_shop_q28_answer = $this->bodyShopAudit->body_shop_q28_answer;
        $this->body_shop_q28_comment = $this->bodyShopAudit->body_shop_q28_comment;
        $this->body_shop_q29_answer = $this->bodyShopAudit->body_shop_q29_answer;
        $this->body_shop_q29_comment = $this->bodyShopAudit->body_shop_q29_comment;
        $this->body_shop_q30_answer = $this->bodyShopAudit->body_shop_q30_answer;
        $this->body_shop_q30_comment = $this->bodyShopAudit->body_shop_q30_comment;
        $this->body_shop_q31_answer = $this->bodyShopAudit->body_shop_q31_answer;
        $this->body_shop_q31_comment = $this->bodyShopAudit->body_shop_q31_comment;
        $this->body_shop_q32_answer = $this->bodyShopAudit->body_shop_q32_answer;
        $this->body_shop_q32_comment = $this->bodyShopAudit->body_shop_q32_comment;
        $this->body_shop_q33_answer = $this->bodyShopAudit->body_shop_q33_answer;
        $this->body_shop_q33_comment = $this->bodyShopAudit->body_shop_q33_comment;
        $this->body_shop_q34_answer = $this->bodyShopAudit->body_shop_q34_answer;
        $this->body_shop_q34_comment = $this->bodyShopAudit->body_shop_q34_comment;
        $this->body_shop_q35_answer = $this->bodyShopAudit->body_shop_q35_answer;
        $this->body_shop_q35_comment = $this->bodyShopAudit->body_shop_q35_comment;
        $this->body_shop_q36_answer = $this->bodyShopAudit->body_shop_q36_answer;
        $this->body_shop_q36_comment = $this->bodyShopAudit->body_shop_q36_comment;
        $this->body_shop_q37_answer = $this->bodyShopAudit->body_shop_q37_answer;
        $this->body_shop_q37_comment = $this->bodyShopAudit->body_shop_q37_comment;
        $this->body_shop_q38_answer = $this->bodyShopAudit->body_shop_q38_answer;
        $this->body_shop_q38_comment = $this->bodyShopAudit->body_shop_q38_comment;
        $this->body_shop_q39_answer = $this->bodyShopAudit->body_shop_q39_answer;
        $this->body_shop_q39_comment = $this->bodyShopAudit->body_shop_q39_comment;
        $this->body_shop_q40_answer = $this->bodyShopAudit->body_shop_q40_answer;
        $this->body_shop_q40_comment = $this->bodyShopAudit->body_shop_q40_comment;
        $this->body_shop_q41_answer = $this->bodyShopAudit->body_shop_q41_answer;
        $this->body_shop_q41_comment = $this->bodyShopAudit->body_shop_q41_comment;
        $this->body_shop_q42_answer = $this->bodyShopAudit->body_shop_q42_answer;
        $this->body_shop_q42_comment = $this->bodyShopAudit->body_shop_q42_comment;
        $this->body_shop_q43_answer = $this->bodyShopAudit->body_shop_q43_answer;
        $this->body_shop_q43_comment = $this->bodyShopAudit->body_shop_q43_comment;
        $this->body_shop_q44_answer = $this->bodyShopAudit->body_shop_q44_answer;
        $this->body_shop_q44_comment = $this->bodyShopAudit->body_shop_q44_comment;
        $this->body_shop_q45_answer = $this->bodyShopAudit->body_shop_q45_answer;
        $this->body_shop_q45_comment = $this->bodyShopAudit->body_shop_q45_comment;
    }

    public function update()
    {
        $this->validate();

        $this->bodyShopAudit->update([
            'draft' => $this->draft,
            'body_shop_q1_answer' => $this->body_shop_q1_answer,
            'body_shop_q1_comment' => $this->body_shop_q1_comment,
            'body_shop_q2_answer' => $this->body_shop_q2_answer,
            'body_shop_q2_comment' => $this->body_shop_q2_comment,
            'body_shop_q3_answer' => $this->body_shop_q3_answer,
            'body_shop_q3_comment' => $this->body_shop_q3_comment,
            'body_shop_q4_answer' => $this->body_shop_q4_answer,
            'body_shop_q4_comment' => $this->body_shop_q4_comment,
            'body_shop_q5_answer' => $this->body_shop_q5_answer,
            'body_shop_q5_comment' => $this->body_shop_q5_comment,
            'body_shop_q6_answer' => $this->body_shop_q6_answer,
            'body_shop_q6_comment' => $this->body_shop_q6_comment,
            'body_shop_q7_answer' => $this->body_shop_q7_answer,
            'body_shop_q7_comment' => $this->body_shop_q7_comment,
            'body_shop_q8_answer' => $this->body_shop_q8_answer,
            'body_shop_q8_comment' => $this->body_shop_q8_comment,
            'body_shop_q9_answer' => $this->body_shop_q9_answer,
            'body_shop_q9_comment' => $this->body_shop_q9_comment,
            'body_shop_q10_answer' => $this->body_shop_q10_answer,
            'body_shop_q10_comment' => $this->body_shop_q10_comment,
            'body_shop_q11_answer' => $this->body_shop_q11_answer,
            'body_shop_q11_comment' => $this->body_shop_q11_comment,
            'body_shop_q12_answer' => $this->body_shop_q12_answer,
            'body_shop_q12_comment' => $this->body_shop_q12_comment,
            'body_shop_q13_answer' => $this->body_shop_q13_answer,
            'body_shop_q13_comment' => $this->body_shop_q13_comment,
            'body_shop_q14_answer' => $this->body_shop_q14_answer,
            'body_shop_q14_comment' => $this->body_shop_q14_comment,
            'body_shop_q15_answer' => $this->body_shop_q15_answer,
            'body_shop_q15_comment' => $this->body_shop_q15_comment,
            'body_shop_q16_answer' => $this->body_shop_q16_answer,
            'body_shop_q16_comment' => $this->body_shop_q16_comment,
            'body_shop_q17_answer' => $this->body_shop_q17_answer,
            'body_shop_q17_comment' => $this->body_shop_q17_comment,
            'body_shop_q18_answer' => $this->body_shop_q18_answer,
            'body_shop_q18_comment' => $this->body_shop_q18_comment,
            'body_shop_q19_answer' => $this->body_shop_q19_answer,
            'body_shop_q19_comment' => $this->body_shop_q19_comment,
            'body_shop_q20_answer' => $this->body_shop_q20_answer,
            'body_shop_q20_comment' => $this->body_shop_q20_comment,
            'body_shop_q21_answer' => $this->body_shop_q21_answer,
            'body_shop_q21_comment' => $this->body_shop_q21_comment,
            'body_shop_q22_answer' => $this->body_shop_q22_answer,
            'body_shop_q22_comment' => $this->body_shop_q22_comment,
            'body_shop_q23_answer' => $this->body_shop_q23_answer,
            'body_shop_q23_comment' => $this->body_shop_q23_comment,
            'body_shop_q24_answer' => $this->body_shop_q24_answer,
            'body_shop_q24_comment' => $this->body_shop_q24_comment,
            'body_shop_q25_answer' => $this->body_shop_q25_answer,
            'body_shop_q25_comment' => $this->body_shop_q25_comment,
            'body_shop_q26_answer' => $this->body_shop_q26_answer,
            'body_shop_q26_comment' => $this->body_shop_q26_comment,
            'body_shop_q27_answer' => $this->body_shop_q27_answer,
            'body_shop_q27_comment' => $this->body_shop_q27_comment,
            'body_shop_q28_answer' => $this->body_shop_q28_answer,
            'body_shop_q28_comment' => $this->body_shop_q28_comment,
            'body_shop_q29_answer' => $this->body_shop_q29_answer,
            'body_shop_q29_comment' => $this->body_shop_q29_comment,
            'body_shop_q30_answer' => $this->body_shop_q30_answer,
            'body_shop_q30_comment' => $this->body_shop_q30_comment,
            'body_shop_q31_answer' => $this->body_shop_q31_answer,
            'body_shop_q31_comment' => $this->body_shop_q31_comment,
            'body_shop_q32_answer' => $this->body_shop_q32_answer,
            'body_shop_q32_comment' => $this->body_shop_q32_comment,
            'body_shop_q33_answer' => $this->body_shop_q33_answer,
            'body_shop_q33_comment' => $this->body_shop_q33_comment,
            'body_shop_q34_answer' => $this->body_shop_q34_answer,
            'body_shop_q34_comment' => $this->body_shop_q34_comment,
            'body_shop_q35_answer' => $this->body_shop_q35_answer,
            'body_shop_q35_comment' => $this->body_shop_q35_comment,
            'body_shop_q36_answer' => $this->body_shop_q36_answer,
            'body_shop_q36_comment' => $this->body_shop_q36_comment,
            'body_shop_q37_answer' => $this->body_shop_q37_answer,
            'body_shop_q37_comment' => $this->body_shop_q37_comment,
            'body_shop_q38_answer' => $this->body_shop_q38_answer,
            'body_shop_q38_comment' => $this->body_shop_q38_comment,
            'body_shop_q39_answer' => $this->body_shop_q39_answer,
            'body_shop_q39_comment' => $this->body_shop_q39_comment,
            'body_shop_q40_answer' => $this->body_shop_q40_answer,
            'body_shop_q40_comment' => $this->body_shop_q40_comment,
            'body_shop_q41_answer' => $this->body_shop_q41_answer,
            'body_shop_q41_comment' => $this->body_shop_q41_comment,
            'body_shop_q42_answer' => $this->body_shop_q42_answer,
            'body_shop_q42_comment' => $this->body_shop_q42_comment,
            'body_shop_q43_answer' => $this->body_shop_q43_answer,
            'body_shop_q43_comment' => $this->body_shop_q43_comment,
            'body_shop_q44_answer' => $this->body_shop_q44_answer,
            'body_shop_q44_comment' => $this->body_shop_q44_comment,
            'body_shop_q45_answer' => $this->body_shop_q45_answer,
            'body_shop_q45_comment' => $this->body_shop_q45_comment
        ]);

        for ($i = 1; $i <= 45; $i++) {
            $this->bodyShopAudit->syncFromMediaLibraryRequest($this->{'body_shop_q' . $i . '_images'})
                ->toMediaCollection('body_shop_q' . $i . '_images');
        }

        Notification::make()
            ->title('Body Shop Audit Updated Successfully!')
            ->success()
            ->send();

        if (tenant('locations')) {
            return redirect(route('dealer.stores.audits.body-shop.index', $this->store));
        } else {
            return redirect(route('dealer.audit.body-shop.index'));
        }
    }
    public function render()
    {
        return view('livewire.dealer.audit.body-shop.show');
    }
}
