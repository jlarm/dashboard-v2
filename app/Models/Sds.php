<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sds extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'product_identifier',
        'product_identification_numbers',
        'manufacturer',
        'cas_nos',
        'common_name',
        'pdf_path',
    ];

    protected $casts = [
        'product_identification_numbers' => 'array',
        'cas_nos' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }
}
