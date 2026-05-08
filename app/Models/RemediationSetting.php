<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Frequency;
use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

/**
 * @property bool $active
 * @property bool $notifications
 * @property Frequency $frequency
 * @property array<int, mixed>|null $managers
 */
class RemediationSetting extends Model
{
    #[Override]
    protected $fillable = [
        'store_id',
        'active',
        'notifications',
        'frequency',
        'managers',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'notifications' => 'boolean',
            'frequency' => Frequency::class,
            'managers' => 'array',
        ];
    }
}
