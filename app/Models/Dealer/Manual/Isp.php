<?php

declare(strict_types=1);

namespace App\Models\Dealer\Manual;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Isp extends Model
{
    use LogsActivity;

    protected $fillable = [
        'store_id',
        'user_id',
        'pdf_path',
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
        'police_emergency_phone',
        'police_non_emergency_phone',
        'fire_emergency_phone',
        'fire_non_emergency_phone',
        'fire_alarm_type',
        'burglar_alarm_type',
        'signature',
    ];

    public function getPhoneNumberAttribute()
    {
        $cleaned = preg_replace('/[^[:digit:]]/', '', $this->phone);
        preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);

        return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }
}
