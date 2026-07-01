<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['trip_id', 'title', 'body', 'mood', 'date', 'color', 'is_private'])]
class Note extends Model
{
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_private' => 'boolean',
        ];
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
