<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    private function loadTrip(Trip $trip): Trip
    {
        return $trip->load(['routeStops', 'expenses', 'photos', 'notes', 'user.profile'])
            ->loadCount(['likes', 'comments']);
    }

    public function index(Request $request)
    {
        $trips = Trip::where('user_id', $request->user()->id)
            ->with(['routeStops', 'expenses', 'photos', 'notes', 'user.profile'])
            ->withCount(['likes', 'comments'])
            ->orderByDesc('created_at')
            ->get();

        return TripResource::collection($trips);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'flag' => 'nullable|string|max:10',
            'status' => 'nullable|in:upcoming,ongoing,completed',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'budget' => 'required|numeric',
            'currency' => 'nullable|string|max:3',
            'coverPhoto' => 'nullable|string',
            'description' => 'nullable|string',
            'transport' => 'nullable|string',
            'route' => 'nullable|array',
            'route.*.label' => 'required_with:route|string',
            'route.*.name' => 'required_with:route|string',
            'route.*.lat' => 'required_with:route|numeric',
            'route.*.lng' => 'required_with:route|numeric',
            'route.*.color' => 'nullable|string',
            'preferences' => 'nullable|array',
            'preferences.purpose' => 'nullable|string',
            'preferences.accommodation' => 'nullable|string',
            'preferences.pace' => 'nullable|string',
            'preferences.foodPriority' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $trip = DB::transaction(function () use ($request) {
            $trip = Trip::create([
                'user_id' => $request->user()->id,
                'name' => $request->name,
                'destination' => $request->destination,
                'flag' => $request->flag,
                'status' => $request->input('status', 'upcoming'),
                'start_date' => $request->startDate,
                'end_date' => $request->endDate,
                'budget' => $request->budget,
                'spent' => 0,
                'currency' => $request->input('currency', 'USD'),
                'cover_photo' => $request->coverPhoto,
                'description' => $request->description,
                'transport' => $request->transport,
                'visibility' => 'private',
                'pref_purpose' => $request->input('preferences.purpose'),
                'pref_accommodation' => $request->input('preferences.accommodation'),
                'pref_pace' => $request->input('preferences.pace'),
                'pref_food_priority' => $request->input('preferences.foodPriority'),
            ]);

            foreach ($request->input('route', []) as $i => $stop) {
                $trip->routeStops()->create([
                    'label' => $stop['label'],
                    'name' => $stop['name'],
                    'lat' => $stop['lat'],
                    'lng' => $stop['lng'],
                    'color' => $stop['color'] ?? null,
                    'position' => $i,
                ]);
            }

            return $trip;
        });

        return new TripResource($this->loadTrip($trip));
    }

    public function show(Request $request, Trip $trip)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        return new TripResource($this->loadTrip($trip));
    }

    public function update(Request $request, Trip $trip)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'destination' => 'sometimes|string|max:255',
            'flag' => 'nullable|string|max:10',
            'status' => 'sometimes|in:upcoming,ongoing,completed',
            'startDate' => 'sometimes|date',
            'endDate' => 'sometimes|date',
            'budget' => 'sometimes|numeric',
            'currency' => 'sometimes|string|max:3',
            'coverPhoto' => 'nullable|string',
            'description' => 'nullable|string',
            'transport' => 'nullable|string',
            'visibility' => 'sometimes|in:public,private',
            'privacySettings' => 'sometimes|array',
            'privacySettings.photos' => 'sometimes|boolean',
            'privacySettings.notes' => 'sometimes|boolean',
            'privacySettings.expenses' => 'sometimes|boolean',
            'preferences' => 'sometimes|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $map = [
            'name' => 'name', 'destination' => 'destination', 'flag' => 'flag',
            'status' => 'status', 'startDate' => 'start_date', 'endDate' => 'end_date',
            'budget' => 'budget', 'currency' => 'currency', 'coverPhoto' => 'cover_photo',
            'description' => 'description', 'transport' => 'transport', 'visibility' => 'visibility',
        ];

        $updates = [];
        foreach ($map as $input => $column) {
            if ($request->has($input)) {
                $updates[$column] = $request->input($input);
            }
        }

        if ($request->has('privacySettings')) {
            foreach (['photos', 'notes', 'expenses'] as $key) {
                if (array_key_exists($key, $request->input('privacySettings', []))) {
                    $updates["privacy_{$key}"] = (bool) $request->input("privacySettings.{$key}");
                }
            }
        }

        if ($request->has('preferences')) {
            $prefMap = ['purpose' => 'pref_purpose', 'accommodation' => 'pref_accommodation', 'pace' => 'pref_pace', 'foodPriority' => 'pref_food_priority'];
            foreach ($prefMap as $input => $column) {
                if (array_key_exists($input, $request->input('preferences', []))) {
                    $updates[$column] = $request->input("preferences.{$input}");
                }
            }
        }

        $trip->update($updates);

        return new TripResource($this->loadTrip($trip));
    }

    public function destroy(Request $request, Trip $trip)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        $trip->delete();

        return response()->json(['message' => 'Trip deleted.']);
    }
}
