<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit;

use App\Models\User;
use App\Observers\DealJacketObserver;
use Database\Factories\Tenant\DealJacketFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Override;

/**
 * @property int $id
 * @property string|null $customer_name
 * @property string|null $customer_deal_number
 * @property string|null $purchase_type
 * @property string|null $vehicle_type
 * @property int|null $mileage
 * @property Carbon|null $date_of_deal_jacket
 * @property array<int, array<string, mixed>>|null $responses
 * @property-read User|null $user
 */
#[ObservedBy(DealJacketObserver::class)]
class DealJacket extends Model
{
    use HasFactory;

    #[Override]
    protected $fillable = [
        'uuid',
        'deal_jacket_group_id',
        'audit_date',
        'date_of_deal_jacket',
        'customer_name',
        'customer_deal_number',
        'user_id',
        'mileage',
        'purchase_type',
        'vehicle_type',
        'responses',
        'total_passed',
        'total_failed',
        'total_high_risk',
        'percentage',
    ];

    /**
     * @return BelongsTo<DealJacketGroup, $this>
     */
    public function dealJacketGroup(): BelongsTo
    {
        return $this->belongsTo(DealJacketGroup::class);
    }

    /**
     * @return BelongsTo<DealJacketGroup, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->dealJacketGroup();
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): DealJacketFactory
    {
        return DealJacketFactory::new();
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'uuid' => 'string',
            'audit_date' => 'date',
            'date_of_deal_jacket' => 'date',
            'customer_name' => 'encrypted',
            'customer_deal_number' => 'encrypted',
            'responses' => 'encrypted:array',
            'total_passed' => 'integer',
            'total_failed' => 'integer',
            'total_high_risk' => 'integer',
            'percentage' => 'integer',
        ];
    }
}
