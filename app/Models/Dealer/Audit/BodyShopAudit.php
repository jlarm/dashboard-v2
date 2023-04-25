<?php

namespace App\Models\Dealer\Audit;

use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BodyShopAudit extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'store_id',
        'draft',
        'body_shop_q1_answer',
        'body_shop_q1_comment',
        'body_shop_q2_answer',
        'body_shop_q2_comment',
        'body_shop_q3_answer',
        'body_shop_q3_comment',
        'body_shop_q4_answer',
        'body_shop_q4_comment',
        'body_shop_q5_answer',
        'body_shop_q5_comment',
        'body_shop_q6_answer',
        'body_shop_q6_comment',
        'body_shop_q7_answer',
        'body_shop_q7_comment',
        'body_shop_q8_answer',
        'body_shop_q8_comment',
        'body_shop_q9_answer',
        'body_shop_q9_comment',
        'body_shop_q10_answer',
        'body_shop_q10_comment',
        'body_shop_q11_answer',
        'body_shop_q11_comment',
        'body_shop_q12_answer',
        'body_shop_q12_comment',
        'body_shop_q13_answer',
        'body_shop_q13_comment',
        'body_shop_q14_answer',
        'body_shop_q14_comment',
        'body_shop_q15_answer',
        'body_shop_q15_comment',
        'body_shop_q16_answer',
        'body_shop_q16_inspection_date',
        'body_shop_q16_comment',
        'body_shop_q17_answer',
        'body_shop_q17_comment',
        'body_shop_q18_answer',
        'body_shop_q18_comment',
        'body_shop_q19_answer',
        'body_shop_q19_comment',
        'body_shop_q20_answer',
        'body_shop_q20_comment',
        'body_shop_q21_answer',
        'body_shop_q21_comment',
        'body_shop_q22_answer',
        'body_shop_q22_comment',
        'body_shop_q23_answer',
        'body_shop_q23_comment',
        'body_shop_q24_answer',
        'body_shop_q24_comment',
        'body_shop_q25_answer',
        'body_shop_q25_comment',
        'body_shop_q26_answer',
        'body_shop_q26_comment',
        'body_shop_q27_answer',
        'body_shop_q27_comment',
        'body_shop_q28_answer',
        'body_shop_q28_comment',
        'body_shop_q29_answer',
        'body_shop_q29_comment',
        'body_shop_q30_answer',
        'body_shop_q30_comment',
        'body_shop_q31_answer',
        'body_shop_q31_comment',
        'body_shop_q32_answer',
        'body_shop_q32_comment',
        'body_shop_q33_answer',
        'body_shop_q33_comment',
        'body_shop_q34_answer',
        'body_shop_q34_comment',
        'body_shop_q35_answer',
        'body_shop_q35_comment',
        'body_shop_q36_answer',
        'body_shop_q36_comment',
        'body_shop_q37_answer',
        'body_shop_q37_comment',
        'body_shop_q38_answer',
        'body_shop_q38_comment',
        'body_shop_q39_answer',
        'body_shop_q39_comment',
        'body_shop_q40_answer',
        'body_shop_q40_comment',
        'body_shop_q41_answer',
        'body_shop_q41_comment',
        'body_shop_q42_answer',
        'body_shop_q42_comment',
        'body_shop_q43_answer',
        'body_shop_q43_comment',
        'body_shop_q44_answer',
        'body_shop_q44_comment',
        'body_shop_q45_answer',
        'body_shop_q45_comment',
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
