<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RemediationReminders extends Model
{
    protected $fillable = [
        'send_date',
        'store_id',
    ];
    protected $casts = [
        'send_date' => 'datetime',
    ];

    public function remindable(): MorphTo
    {
        return $this->morphTo();
    }
}
