<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'new_follower', 'trip_liked', 'trip_commented', 'followed_user_trip'])]
class NotificationPreference extends Model
{
    protected function casts(): array
    {
        return [
            'new_follower' => 'boolean',
            'trip_liked' => 'boolean',
            'trip_commented' => 'boolean',
            'followed_user_trip' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
