<?php

namespace App\Models\Dealer\Manual;

use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Model;

class Isp extends Model
{
    protected $fillable = [
        'store_id',
        'logged_in_user',
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

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
