<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id', 'name', 'destination', 'flag', 'status', 'start_date', 'end_date',
    'budget', 'spent', 'currency', 'cover_photo', 'description', 'transport',
    'visibility', 'privacy_photos', 'privacy_notes', 'privacy_expenses',
    'pref_purpose', 'pref_accommodation', 'pref_pace', 'pref_food_priority',
])]
class Trip extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'budget' => 'decimal:2',
            'spent' => 'decimal:2',
            'privacy_photos' => 'boolean',
            'privacy_notes' => 'boolean',
            'privacy_expenses' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function routeStops(): HasMany
    {
        return $this->hasMany(RouteStop::class)->orderBy('position');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
