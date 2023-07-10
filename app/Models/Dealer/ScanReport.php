<?php

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScanReport extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'path',
        'type',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
