<?php

declare(strict_types=1);

namespace App\Models\Central;

use App\Models\User;
use Database\Factories\Central\UserInviteFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class UserInvite extends Model
{
    /** @use HasFactory<UserInviteFactory> */
    use HasFactory;

    public const string CONSULTANT_ROLE = 'Consultant';

    #[Override]
    protected $fillable = [
        'name',
        'email',
        'role',
        'invited_by',
        'expires_at',
        'accepted_at',
        'revoked_at',
    ];

    /**
     * @return BelongsTo<User, UserInvite>
     */
    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function isActive(): bool
    {
        return $this->accepted_at === null
            && $this->revoked_at === null
            && $this->expires_at->isFuture();
    }

    public function isInactive(): bool
    {
        return ! $this->isActive();
    }

    protected function scopeOpen(Builder $query): Builder
    {
        return $query->whereNull('accepted_at')
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now());
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'email' => 'string',
            'role' => 'string',
            'invited_by' => 'integer',
            'expires_at' => 'datetime',
            'accepted_at' => 'datetime',
            'revoked_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
