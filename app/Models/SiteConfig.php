<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class SiteConfig extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
        'is_finished' => 'boolean',
    ];

    public function scopeIsFinished(Builder $query): Builder
    {
        return $query->where('is_finished', true);
    }

    public function scopeIsNotFinished(Builder $query): Builder
    {
        return $query->where('is_finished', false);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
