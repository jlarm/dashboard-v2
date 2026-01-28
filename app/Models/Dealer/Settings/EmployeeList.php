<?php

declare(strict_types=1);

namespace App\Models\Dealer\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeList extends Model
{
    use LogsActivity;

    protected $fillable = [
        'store_id',
        'qualified_individual_name',
        'qualified_individual_phone',
        'service_manager_name',
        'service_manager_phone',
        'parts_manager_name',
        'parts_manager_phone',
        'body_shop_manager_name',
        'body_shop_manager_phone',
        'general_manager_name',
        'general_manager_phone',
        'owner_name',
        'owner_phone',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Dealer\Store::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }
}
