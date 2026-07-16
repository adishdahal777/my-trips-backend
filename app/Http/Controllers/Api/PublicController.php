<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\TripView;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    private function applyPrivacyFilter(Trip $trip): Trip
    {
        $trip->setRelation('photos', $trip->privacy_photos ? $trip->photos->where('is_private', false)->values() : collect());
        $trip->setRelation('notes', $trip->privacy_notes ? $trip->notes->where('is_private', false)->values() : collect());
        $trip->setRelation('expenses', $trip->privacy_expenses ? $trip->expenses->where('is_private', false)->values() : collect());

        return $trip;
    }

    public function index()
    {
        $trips = Trip::where('visibility', 'public')
            ->with(['routeStops', 'expenses', 'photos', 'notes', 'user.profile'])
            ->withCount(['likes', 'comments'])
            ->orderByDesc('created_at')
            ->limit(50)
            ->get()
            ->map(fn (Trip $trip) => $this->applyPrivacyFilter($trip));

        return TripResource::collection($trips);
    }

    public function show(Request $request, Trip $trip)
    {
        abort_unless($trip->visibility === 'public', 404);

        $viewer = $request->user('sanctum');
        if ($viewer && $viewer->id !== $trip->user_id) {
            TripView::create(['user_id' => $viewer->id, 'trip_id' => $trip->id]);
        }

        $trip->load(['routeStops', 'expenses', 'photos', 'notes', 'user.profile'])
            ->loadCount(['likes', 'comments']);

        return new TripResource($this->applyPrivacyFilter($trip));
    }
}
