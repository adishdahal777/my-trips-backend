<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppRating;
use App\Models\FeatureCard;
use App\Models\Photo;
use App\Models\Trip;
use App\Models\User;
use App\Models\UserProfile;

class LandingController extends Controller
{
    public function index()
    {
        $ratings = AppRating::where('is_featured', true)->with('user')->latest()->limit(3)->get();

        return response()->json([
            'stats' => [
                'totalTrips' => Trip::where('visibility', 'public')->count(),
                'totalUsers' => User::count(),
                'totalPhotos' => Photo::count(),
            ],
            'featureCards' => FeatureCard::orderBy('position')->get()->map(fn ($card) => [
                'id' => (string) $card->id,
                'icon' => $card->icon,
                'colorKey' => $card->color_key,
                'title' => $card->title,
                'description' => $card->description,
            ]),
            'ratings' => $ratings->map(fn ($rating) => [
                'id' => (string) $rating->id,
                'stars' => $rating->stars,
                'comment' => $rating->comment,
                'user' => [
                    'name' => $rating->user->name,
                    'avatar' => $rating->user->profile->avatar ?? UserProfile::DEFAULT_AVATAR,
                ],
            ]),
        ]);
    }
}
