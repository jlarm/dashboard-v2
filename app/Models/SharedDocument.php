<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_name',
        'url',
    ];
    protected $casts = [
        'title' => 'string',
        'file_name' => 'string',
        'url' => 'string',
    ];
}
