<?php

declare(strict_types=1);

namespace App\Models\Dealer\Manual;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Glb extends Model
{
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'fax',
        'website',
        'qi',
        'receptacles',
        'managers',
        'assessment_company',
        'assessment_name',
        'assessment_date',
        'q1a',
        'q1c',
        'q2a',
        'q2c',
        'q3a',
        'q3c',
        'q4a',
        'q4c',
        'q5a',
        'q5c',
        'q6a',
        'q6c',
        'q7a',
        'q7c',
        'q8a',
        'q8c',
        'q9a',
        'q9c',
        'q10a',
        'q10c',
        'q11a',
        'q11c',
        'q12a',
        'q12c',
    ];
    protected $casts = [
        'assessment_date' => 'date',
        'receptacles' => 'array',
        'managers' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }
}
