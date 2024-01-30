<?php

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
