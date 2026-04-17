<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class Event extends Model
{
    #[Override]
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'address',
        'city',
        'state',
        'zip_code',
        'location_name',
        'link',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'start_date' => 'date:Y-m-d',
            'end_date' => 'date:Y-m-d',
        ];
    }
}
