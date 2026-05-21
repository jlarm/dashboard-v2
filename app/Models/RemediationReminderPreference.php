<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AuditTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

/**
 * @property int $user_id
 * @property AuditTypes $audit_type
 * @property bool $enabled
 */
class RemediationReminderPreference extends Model
{
    #[Override]
    protected $fillable = [
        'user_id',
        'audit_type',
        'enabled',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'audit_type' => AuditTypes::class,
            'enabled' => 'boolean',
        ];
    }
}
