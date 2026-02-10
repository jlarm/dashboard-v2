<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorEmailLogIndex extends Model
{
    protected $fillable = [
        'tenant_id',
        'message_id',
    ];
}
