<?php

namespace App\Http\Resources;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $profile = $this->profile;

        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'avatar' => $profile?->avatar ?? UserProfile::DEFAULT_AVATAR,
            'bio' => $profile?->bio,
            'memberSince' => $this->created_at->format('Y'),
            'totalTrips' => $this->trips_count ?? $this->trips()->where('visibility', 'public')->count(),
            'countries' => $profile?->countries ?? 0,
            'kmTraveled' => (float) ($profile?->km_traveled ?? 0),
            'followersCount' => (int) ($this->followers_count ?? $this->followers()->count()),
            'followingCount' => (int) ($this->following_count ?? $this->following()->count()),
        ];
    }
}
