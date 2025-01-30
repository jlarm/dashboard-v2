<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharedDocument extends Model
{
    protected $fillable = [
        'title',
        'url',
        'file_name',
    ];
}
