<?php

namespace App\Models\Dealer\Audit;

use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FinanceAudit extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'store_id',
        'draft',
        'finance_q1_answer',
        'finance_q1_comment',
        'finance_q2_answer',
        'finance_q2_comment',
        'finance_q3_answer',
        'finance_q3_comment',
        'finance_q4_answer',
        'finance_q4_comment',
        'finance_q5_answer',
        'finance_q5_comment',
        'finance_q6_answer',
        'finance_q6_comment',
        'finance_q7_answer',
        'finance_q7_comment',
        'finance_q8_answer',
        'finance_q8_comment',
        'finance_q9_answer',
        'finance_q9_comment',
        'finance_q10_answer',
        'finance_q10_comment',
        'finance_q11_answer',
        'finance_q11_comment',
        'finance_q12_answer',
        'finance_q12_comment',
        'finance_q13_answer',
        'finance_q13_comment',
        'finance_q14_answer',
        'finance_q14_comment',
        'finance_q15_answer',
        'finance_q15_comment',
        'finance_q16_answer',
        'finance_q16_comment',
        'finance_q17_answer',
        'finance_q17_comment',
        'finance_q18_answer',
        'finance_q18_comment',
        'finance_q19_answer',
        'finance_q19_comment',
        'finance_q20_answer',
        'finance_q20_comment',
        'finance_q21_answer',
        'finance_q21_comment',
        'finance_q22_answer',
        'finance_q22_comment',
        'finance_q23_answer',
        'finance_q23_comment',
        'finance_q24_answer',
        'finance_q24_comment',
        'finance_q25_answer',
        'finance_q25_comment',
        'finance_q26_answer',
        'finance_q26_comment',
        'finance_q27_answer',
        'finance_q27_comment',
        'finance_q28_answer',
        'finance_q28_comment',
        'finance_q29_answer',
        'finance_q29_comment',
        'finance_q30_answer',
        'finance_q30_comment',
        'finance_q31_answer',
        'finance_q31_comment',
        'finance_q32_answer',
        'finance_q32_comment',
        'finance_q33_answer',
        'finance_q33_comment',
        'finance_q34_answer',
        'finance_q34_comment',
        'finance_q35_answer',
        'finance_q35_comment',
        'finance_q36_answer',
        'finance_q36_comment',
        'finance_q37_answer',
        'finance_q37_comment',
        'finance_q38_answer',
        'finance_q38_comment',
        'finance_q39_answer',
        'finance_q39_comment',
        'finance_q40_answer',
        'finance_q40_comment',
        'finance_q41_answer',
        'finance_q41_comment',
        'finance_q42_answer',
        'finance_q42_comment',
        'finance_q43_answer',
        'finance_q43_comment',
        'finance_q44_answer',
        'finance_q44_comment',
        'finance_q45_answer',
        'finance_q45_comment'
        ];
    protected $casts = [
        'draft' => 'boolean',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function getPathToMedia(Media $media): string
    {
        return tenant('id') . '/' . $media->collection_name . '/' . $media->id . '/';
    }
}
