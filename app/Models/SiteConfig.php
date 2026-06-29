<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteConfig extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
        'is_finished' => 'boolean',
        'photos' => 'array',
    ];

    /**
     * Etapas do site no pipeline de produção, em ordem.
     */
    public const STAGES = [
        'received' => 'Recebido',
        'in_progress' => 'Em configuração',
        'review' => 'Em ajustes',
        'live' => 'No ar',
    ];

    public function stageLabel(): string
    {
        return self::STAGES[$this->stage] ?? 'Recebido';
    }

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
