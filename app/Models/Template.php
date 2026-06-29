<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Template extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'features' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Template $template) {
            $template->slug = Str::slug($template->name);
        });

        static::updating(function (Template $template) {
            $template->slug = Str::slug($template->name);
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Vínculo legado de plano único (mantido por compatibilidade). O
     * relacionamento principal agora é o N:N em plans().
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class);
    }
}
