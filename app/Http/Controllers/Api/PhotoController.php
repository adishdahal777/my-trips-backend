<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Photo;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhotoController extends Controller
{
    private function freshTrip(Trip $trip): TripResource
    {
        return new TripResource(
            $trip->fresh(['routeStops', 'expenses', 'photos', 'notes', 'user.profile'])
                ->loadCount(['likes', 'comments'])
        );
    }

    public function store(Request $request, Trip $trip)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        $validator = Validator::make($request->all(), [
            'url' => 'required|string',
            'caption' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'date' => 'nullable|date',
            'isPrivate' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $trip->photos()->create([
            'url' => $request->url,
            'caption' => $request->caption,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'date' => $request->date,
            'is_private' => $request->boolean('isPrivate'),
        ]);

        return $this->freshTrip($trip);
    }

    public function update(Request $request, Trip $trip, Photo $photo)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);
        abort_unless($photo->trip_id === $trip->id, 404);

        if ($request->has('isPrivate')) {
            $photo->update(['is_private' => $request->boolean('isPrivate')]);
        }
        if ($request->has('caption')) {
            $photo->update(['caption' => $request->caption]);
        }

        return $this->freshTrip($trip);
    }

    public function destroy(Request $request, Trip $trip, Photo $photo)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);
        abort_unless($photo->trip_id === $trip->id, 404);

        $photo->delete();

        return $this->freshTrip($trip);
    }
}
