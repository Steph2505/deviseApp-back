<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class UserAccessRight extends Model
{
    protected $fillable = [
        'user_id',
        'access_right_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accessRight() : BelongsTo   
    {
        return $this->belongsTo(AccessRight::class);
    }
}