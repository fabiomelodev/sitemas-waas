<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportTicket extends Model
{
    protected $guarded = ['id'];

    public const STATUSES = [
        'open' => 'Aberto',
        'in_progress' => 'Em atendimento',
        'closed' => 'Resolvido',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
