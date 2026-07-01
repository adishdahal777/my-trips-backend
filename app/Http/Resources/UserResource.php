<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $profile = $this->profile;

        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $profile?->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=200',
            'memberSince' => $this->created_at->format('Y'),
            'totalTrips' => $profile?->total_trips ?? 0,
            'countries' => $profile?->countries ?? 0,
            'kmTraveled' => (float) ($profile?->km_traveled ?? 0),
        ];
    }
}
