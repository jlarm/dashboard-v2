<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit;

use App\Models\Dealer\Store;
use App\Observers\DealJacketGroupObserver;
use Database\Factories\Tenant\DealJacketGroupFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

/**
 * @property int $total_passed
 * @property int $total_failed
 */
#[ObservedBy(DealJacketGroupObserver::class)]
class DealJacketGroup extends Model
{
    use HasFactory;

    #[Override]
    protected $fillable = [
        'uuid',
        'store_id',
        'completed',
    ];

    /**
     * @return BelongsTo<Store, $this>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * @return HasMany<DealJacket, $this>
     */
    public function dealJackets(): HasMany
    {
        return $this->hasMany(DealJacket::class);
    }

    /**
     * Eager-aggregates each group's average per-deal-jacket weighted
     * percentage (DealJacket.percentage, populated by SaveDealJacket).
     * This is the single source of truth for the "pass rate" / score
     * shown anywhere on the dashboard — chart, list rows, group header tile.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeWithAveragePercentage(Builder $query): Builder
    {
        return $query->withAvg('dealJackets as average_percentage', 'percentage');
    }

    protected static function newFactory(): DealJacketGroupFactory
    {
        return DealJacketGroupFactory::new();
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'uuid' => 'string',
            'store_id' => 'integer',
            'completed' => 'boolean',
        ];
    }
}
