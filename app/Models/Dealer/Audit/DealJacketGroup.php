<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit;

use App\Models\Dealer\Store;
use App\Observers\DealJacketGroupObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $total_passed
 * @property int $total_failed
 */
#[ObservedBy(DealJacketGroupObserver::class)]
class DealJacketGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'store_id',
        'completed',
    ];
    protected $casts = [
        'uuid' => 'string',
        'store_id' => 'integer',
        'completed' => 'boolean',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function dealJackets(): HasMany
    {
        return $this->hasMany(DealJacket::class);
    }

    public function getPassRateAttribute(): ?float
    {
        $total = $this->total_passed + $this->total_failed;

        return $total > 0
            ? round(($this->total_passed / $total) * 100, 1)
            : null;
    }

    protected static function newFactory(): \Database\Factories\Tenant\DealJacketGroupFactory
    {
        return \Database\Factories\Tenant\DealJacketGroupFactory::new();
    }
}
