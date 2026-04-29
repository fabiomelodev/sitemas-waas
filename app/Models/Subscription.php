<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Subscription extends Model
{
    protected $guarded = ['id'];

    protected $casts = ['expires_at' => 'datetime'];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
