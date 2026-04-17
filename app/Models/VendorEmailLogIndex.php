<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class VendorEmailLogIndex extends Model
{
    #[Override]
    protected $fillable = [
        'tenant_id',
        'message_id',
    ];
}
