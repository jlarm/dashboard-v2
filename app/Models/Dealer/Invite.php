<?php

namespace App\Models\Dealer;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = [
        'name',
        'email',
        'store_id',
        'department_id',
        'user_id',
        'roles',
        'invitation_token',
        'registered_at'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('F-m-Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
