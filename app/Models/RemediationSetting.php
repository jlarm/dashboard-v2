<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Frequency;
use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemediationSetting extends Model
{
    protected $fillable = [
        'store_id',
        'active',
        'notifications',
        'frequency',
        'managers',
    ];
    protected $casts = [
        'active' => 'boolean',
        'notifications' => 'boolean',
        'frequency' => Frequency::class,
        'managers' => 'array',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
