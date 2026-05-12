<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $guarded = ['id'];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }
}
