<?php

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'contact_name',
        'contact_email',
    ];
}
