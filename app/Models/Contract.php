<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Browsershot\Browsershot;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
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
    ];

    protected $casts = [
        'agreement_date' => 'date',
        'services' => 'array',
        'commence_date' => 'date',
        'armp_date_signed' => 'date',
        'dealer_date_signed' => 'date',
        'initial_fee' => MoneyCast::class,
        'monthly_fee' => MoneyCast::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): HasMany
    {
        return $this->hasMany(ContractStatus::class);
    }

    protected static function booted()
    {
        static::creating(function ($contract) {
            $contract->user_id = auth()->id();
            $contract->uuid = (string) \Str::uuid();
        });
    }

    protected function reviewLabel($service): string
    {
        return match ($service) {
            'glba' => 'GLBA - Safeguards Rule, Sales & Finance',
            'osha' => 'OSHA',
            'it' => 'IT Security',
            'ces' => 'Cyber Enhanced Security',
        };
    }

    public function pdf()
    {
        $services = json_decode($this->services);
        $reviewedServices = [];

        foreach ($services as $service) {
            $reviewedServices[] = $this->reviewLabel($service);
        }

        $html = view('central.contract.pdf', [
            'contract' => $this,
            'services' => $reviewedServices
        ])->render();

        return Browsershot::html($html)
            ->showBrowserHeaderAndFooter()
            ->headerHtml('.')
            ->footerHtml(\View::make('pdf.contract.footer'))
            ->format('A4')
            ->margins(10, 20, 10, 20)
            ->scale(0.75)
            ->pdf();
    }

}
