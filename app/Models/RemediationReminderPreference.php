<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AuditTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemediationReminderPreference extends Model
{
    protected $fillable = [
        'user_id',
        'audit_type',
        'enabled',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'audit_type' => AuditTypes::class,
            'enabled' => 'boolean',
        ];
    }
}
