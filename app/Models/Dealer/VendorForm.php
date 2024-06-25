<?php

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorForm extends Model
{
    protected $fillable = [
        'vendor_id',
        'name',
        'email',
        'signature',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
