<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ScanSetting extends Model
{
    use LogsActivity;

    public $timestamps = false;
    protected $fillable = [
        'store_id',
        'name',
        'external_id',
        'internal_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }
}
