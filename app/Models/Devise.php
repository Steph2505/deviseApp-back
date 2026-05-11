<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Devise extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','symbol','exchange_rate','is_active','user_id'];

    protected $casts = [
        'exchange_rate' => 'decimal:6',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
