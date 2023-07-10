<?php

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;

class ScanReport extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'path',
        'type',
    ];
}
