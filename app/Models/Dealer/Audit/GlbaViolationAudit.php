<?php

namespace App\Models\Dealer\Audit;

use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GlbaViolationAudit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'store_id',
        'pdf_path',
        'date',
        'grade',
    ];

    protected $casts = [
        'uuid' => 'string',
        'date' => 'date',
        'data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function violations(): MorphMany
    {
        return $this->morphMany(Violation::class, 'violationable');
    }
}
