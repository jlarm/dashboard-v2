<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class DealJacketQuestion extends Model
{
    #[Override]
    protected $fillable = [
        'question',
        'statement',
        'categories',
        'weight',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'question' => 'string',
            'statement' => 'string',
            'categories' => 'array',
            'weight' => 'integer',
        ];
    }
}
