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

#[ObservedBy(DealJacketObserver::class)]
class DealJacket extends Model
{
    use HasFactory;

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
    protected $casts = [
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

    public function dealJacketGroup(): BelongsTo
    {
        return $this->belongsTo(DealJacketGroup::class);
    }

    public function parent(): BelongsTo
    {
        return $this->dealJacketGroup();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): DealJacketFactory
    {
        return DealJacketFactory::new();
    }
}
