<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Invite extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'stores',
        'department_id',
        'user_id',
        'roles',
        'invitation_token',
        'registered_at',
        'courses',
    ];
    protected $casts = [
        'stores' => 'array',
        'roles' => 'array',
        'courses' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('F-m-Y');
    }
}
