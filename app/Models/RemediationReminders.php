<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Override;

class RemediationReminders extends Model
{
    #[Override]
    protected $fillable = [
        'send_date',
        'store_id',
    ];

    /**
     * @return MorphTo<Model, $this>
     */
    public function remindable(): MorphTo
    {
        return $this->morphTo();
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'send_date' => 'datetime',
        ];
    }
}
