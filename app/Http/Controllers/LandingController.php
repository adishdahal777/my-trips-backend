<?php

namespace App\Http\Controllers;

use App\Models\AppRating;
use App\Models\Destination;
use App\Models\FeatureCard;
use App\Models\LandingSection;
use App\Models\Photo;
use App\Models\ProcessStep;
use App\Models\Trip;
use App\Models\User;

class LandingController extends Controller
{
    public function index()
    {
        $publicTrips = Trip::where('visibility', 'public')
            ->where('is_featured', true)
            ->with('user')
            ->withCount('routeStops')
            ->latest()
            ->limit(6)
            ->get();

        $sections = LandingSection::all()->keyBy('key');

        return view('pages.landing', [
            'publicTrips' => $publicTrips,
            'totalTrips' => Trip::where('visibility', 'public')->count(),
            'totalUsers' => User::count(),
            'totalPhotos' => Photo::count(),
            'sections' => $sections,
            'featureCards' => FeatureCard::orderBy('position')->get(),
            'processSteps' => ProcessStep::orderBy('position')->get(),
            'destinations' => Destination::where('status', 'approved')
                ->where('is_featured', true)
                ->orderByDesc('trip_count')
                ->limit(6)
                ->get(),
            'ratings' => AppRating::where('is_featured', true)
                ->with('user')
                ->latest()
                ->limit(3)
                ->get(),
        ]);
    }
}
