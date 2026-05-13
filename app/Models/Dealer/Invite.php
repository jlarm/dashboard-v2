<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Override;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property string|null $email
 * @property string|null $name
 * @property array<int, mixed>|null $stores
 * @property array<int, mixed>|null $roles
 * @property array<int, mixed>|null $courses
 * @property Carbon $created_at
 */
class Invite extends Model
{
    use LogsActivity;

    #[Override]
    protected $fillable = [
        'name',
        'email',
        'stores',
        'primary_store_id',
        'department_id',
        'user_id',
        'roles',
        'invitation_token',
        'registered_at',
        'courses',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Store, $this>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logExcept(['invitation_token']);
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value): ?string => $value === null ? null : Str::lower($value),
            set: fn (?string $value): ?string => $value === null ? null : Str::lower(mb_trim($value)),
        );
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'stores' => 'array',
            'roles' => 'array',
            'courses' => 'array',
        ];
    }

    #[Override]
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('F-m-Y');
    }
}
