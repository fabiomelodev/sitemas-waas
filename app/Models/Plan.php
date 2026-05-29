<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Plan extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'features' => 'array',
        'is_recommended' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->slug = Str::slug($model->name);
        });

        static::updating(function (Model $model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }
}
