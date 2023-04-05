<?php

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;

class ScanSetting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'store_id',
        'name',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
