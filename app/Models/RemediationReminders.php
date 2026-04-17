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

    public function remindable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'send_date' => 'datetime',
        ];
    }
}
