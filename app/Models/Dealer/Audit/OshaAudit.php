<?php

namespace App\Models\Dealer\Audit;

use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class OshaAudit extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'store_id',
        'draft',
        'osha_q1_answer',
        'osha_q1_comment',
        'osha_q2_answer',
        'osha_q2_comment',
        'osha_q3_answer',
        'osha_q3_comment',
        'osha_q4_answer',
        'osha_q4_comment',
        'osha_q5_answer',
        'osha_q5_comment',
        'osha_q6_answer',
        'osha_q6_comment',
        'osha_q7_answer',
        'osha_q7_comment',
        'osha_q8_answer',
        'osha_q8_comment',
        'osha_q9_answer',
        'osha_q9_comment',
        'osha_q10_answer',
        'osha_q10_comment',
        'osha_q11_answer',
        'osha_q11_comment',
        'osha_q12_answer',
        'osha_q12_comment',
        'osha_q13_answer',
        'osha_q13_comment',
        'osha_q14_answer',
        'osha_q14_comment',
        'osha_q15_answer',
        'osha_q15_comment',
        'osha_q16_answer',
        'osha_q16_comment',
        'osha_q17_answer',
        'osha_q17_comment',
        'osha_q18_answer',
        'osha_q18_comment',
        'osha_q19_answer',
        'osha_q19_comment',
        'osha_q20_answer',
        'osha_q20_comment',
        'osha_q21_answer',
        'osha_q21_comment',
        'osha_q22_answer',
        'osha_q22_comment',
        'osha_q23_answer',
        'osha_q23_comment',
        'osha_q24_answer',
        'osha_q24_comment',
        'osha_q25_answer',
        'osha_q25_comment',
        'osha_q26_answer',
        'osha_q26_comment',
        'osha_q27_answer',
        'osha_q27_comment',
        'osha_q28_answer',
        'osha_q28_comment',
        'osha_q29_answer',
        'osha_q29_comment',
        'osha_q30_answer',
        'osha_q30_comment',
        'osha_q31_answer',
        'osha_q31_comment',
        'osha_q32_answer',
        'osha_q32_comment',
        'osha_q33_answer',
        'osha_q33_comment',
        'osha_q34_answer',
        'osha_q34_comment',
        'osha_q35_answer',
        'osha_q35_comment',
        'osha_q36_answer',
        'osha_q36_comment',
        'osha_q37_answer',
        'osha_q37_comment',
        'osha_q38_answer',
        'osha_q38_comment',
        'osha_q39_answer',
        'osha_q39_comment',
        'osha_q40_answer',
        'osha_q40_comment',
        'osha_q41_answer',
        'osha_q41_comment',
        'osha_q42_answer',
        'osha_q42_comment',
        'osha_q43_answer',
        'osha_q43_comment',
        'osha_q44_answer',
        'osha_q44_comment',
        'osha_q45_answer',
        'osha_q45_comment',
        'osha_q46_answer',
        'osha_q46_comment',
        'osha_q47_answer',
        'osha_q47_comment',
        'osha_q48_answer',
        'osha_q48_comment',
        'osha_q49_answer',
        'osha_q49_comment',
        'osha_q50_answer',
        'osha_q50_comment',
        'osha_q51_answer',
        'osha_q51_comment',
        'osha_q52_answer',
        'osha_q52_comment',
        'osha_q53_answer',
        'osha_q53_comment',
        'osha_q54_answer',
        'osha_q54_comment',
        'osha_q55_answer',
        'osha_q55_comment',
        'osha_q56_answer',
        'osha_q56_comment',
        'osha_q57_answer',
        'osha_q57_comment',
        'osha_q58_answer',
        'osha_q58_comment',
        'osha_q59_answer',
        'osha_q59_comment',
        'osha_q60_answer',
        'osha_q60_comment',
        'osha_q61_answer',
        'osha_q61_comment',
        'osha_q62_answer',
        'osha_q62_comment',
        'osha_q63_answer',
        'osha_q63_comment',
        'osha_q64_answer',
        'osha_q64_comment',
        'osha_q65_answer',
        'osha_q65_comment',
        'osha_q66_answer',
        'osha_q66_comment',
        'osha_q67_answer',
        'osha_q67_comment',
        'osha_q68_answer',
        'osha_q68_comment',
        'osha_q69_answer',
        'osha_q69_comment',
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
