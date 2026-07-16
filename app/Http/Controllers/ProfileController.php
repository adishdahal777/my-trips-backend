<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $trips = Trip::where('user_id', $user->id)
            ->where('visibility', 'public')
            ->withCount('routeStops')
            ->latest()
            ->get();

        return view('pages.profile', [
            'profileUser' => $user->load('profile'),
            'trips' => $trips,
            'followersCount' => $user->followers()->count(),
            'followingCount' => $user->following()->count(),
        ]);
    }
}
