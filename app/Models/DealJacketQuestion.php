<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealJacketQuestion extends Model
{
    protected $fillable = [
        'question',
        'statement',
        'categories',
        'weight',
    ];
    protected $casts = [
        'question' => 'string',
        'statement' => 'string',
        'categories' => 'array',
        'weight' => 'integer',
    ];
}
