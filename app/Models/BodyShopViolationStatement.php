<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodyShopViolationStatement extends Model
{
    protected $fillable = [
        'statement',
        'keywords',
    ];
    protected $casts = [
        'keywords' => 'array',
    ];
}
