<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'destination' => $this->destination,
            'flag' => $this->flag,
            'status' => $this->status,
            'startDate' => $this->start_date->format('Y-m-d'),
            'endDate' => $this->end_date->format('Y-m-d'),
            'budget' => (float) $this->budget,
            'spent' => (float) $this->spent,
            'currency' => $this->currency,
            'coverPhoto' => $this->cover_photo,
            'description' => $this->description,
            'transport' => $this->transport,
            'route' => RouteStopResource::collection($this->whenLoaded('routeStops')),
            'expenses' => ExpenseResource::collection($this->whenLoaded('expenses')),
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
            'notes' => NoteResource::collection($this->whenLoaded('notes')),
            'preferences' => [
                'purpose' => $this->pref_purpose,
                'accommodation' => $this->pref_accommodation,
                'pace' => $this->pref_pace,
                'foodPriority' => $this->pref_food_priority,
            ],
            'visibility' => $this->visibility,
            'privacySettings' => [
                'photos' => (bool) $this->privacy_photos,
                'notes' => (bool) $this->privacy_notes,
                'expenses' => (bool) $this->privacy_expenses,
            ],
            'user' => $this->whenLoaded('user', fn () => [
                'id' => (string) $this->user->id,
                'name' => $this->user->name,
                'avatar' => $this->user->profile?->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=200',
            ]),
            'likes' => (int) ($this->likes_count ?? $this->likes()->count()),
            'comments' => (int) ($this->comments_count ?? $this->comments()->count()),
            'createdAt' => $this->created_at->toISOString(),
        ];
    }
}
