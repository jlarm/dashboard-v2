<?php

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Vendor extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'contact_name',
        'contact_email',
        'store_id',
        'signature',
        'q1a',
        'q1c',
        'q2a',
        'q2c',
        'q3a',
        'q3c',
        'q4a',
        'q4c',
        'q5a',
        'q5c',
        'q6a',
        'q6c',
        'q7a',
        'q7c',
        'q8a',
        'q8c',
        'q9a',
        'q9c',
        'q10a',
        'q10c',
        'q11a',
        'q11c',
        'q12a',
        'q12c',
        'q13a',
        'q13c',
        'q14a',
        'q14c',
        'q15a',
        'q15c',
        'q16a',
        'q16c',
        'q17a',
        'q17c',
        'q18a',
        'q18c',
        'q19a',
        'q19c',
        'q20a',
        'q20c',
        'q21a',
        'q21c',
        'q22a',
        'q22c',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function forms(): HasMany
    {
        return $this->hasMany(VendorForm::class);
    }
}
