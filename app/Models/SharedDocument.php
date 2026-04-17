<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;

class SharedDocument extends Model
{
    use HasFactory;

    #[Override]
    protected $fillable = [
        'title',
        'file_name',
        'url',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'title' => 'string',
            'file_name' => 'string',
            'url' => 'string',
        ];
    }
}
