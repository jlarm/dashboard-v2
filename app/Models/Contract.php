<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\MoneyCast;
use Database\Factories\Central\ContractFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'contract_type',
        'agreement_date',
        'dealer_name',
        'services',
        'commence_date',
        'yearly_inspection_total',
        'initial_fee',
        'monthly_fee',
        'armp_signature',
        'armp_printed_name',
        'armp_date_signed',
        'dealer_signature',
        'dealer_printed_name',
        'dealer_date_signed',
        'dealer_physical_address',
        'dealer_physical_city',
        'dealer_physical_state',
        'dealer_physical_zip',
        'dealer_phone',
        'dealer_qi_name',
        'dealer_qi_email',
        'dealer_billing_address',
        'dealer_billing_city',
        'dealer_billing_state',
        'dealer_billing_zip',
        'dealer_billing_fax',
        'dealer_billing_contact_name',
        'dealer_billing_contact_title',
        'dealer_billing_contact_email',
        'additional_locations',
        'pdf_path',
    ];
    protected $casts = [
        'agreement_date' => 'date',
        'services' => 'array',
        'commence_date' => 'date',
        'armp_date_signed' => 'date',
        'dealer_date_signed' => 'date',
        'initial_fee' => MoneyCast::class,
        'monthly_fee' => MoneyCast::class,
        'additional_locations' => 'array',
    ];

    /**
     * @return BelongsTo<User, Contract>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<ContractStatus>
     */
    public function status(): HasMany
    {
        return $this->hasMany(ContractStatus::class);
    }

    /**
     * @return Factory<Contract>
     */
    protected static function newFactory(): Factory
    {
        return ContractFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(static function ($contract): void {
            if (! $contract->user_id) {
                $contract->user_id = auth()->id();
            }

            if (! $contract->uuid) {
                $contract->uuid = (string) Str::uuid();
            }
        });
    }
}
