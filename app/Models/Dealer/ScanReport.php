<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScanReport extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'path',
        'type',
        'scan_type',
        'grade',
        'exploits_high',
        'exploits_medium',
        'exploits_low',
        'cves_high',
        'cves_medium',
        'cves_low',
        'assets',
        'last_scan',
        'next_scan',
        'last_scan_status',
        'last_scan_progress',
        'last_scan_errors',
        'created_at',
        'updated_at',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
